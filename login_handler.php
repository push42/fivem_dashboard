<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


// Check if the user is already logged in, then redirect to index page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "webdev");

    // Check if the connection was successful
    if (!$con) {
        die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
    }

    // Sanitize the user input to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    // Prepare and execute the SELECT statement
    $stmt = $con->prepare("SELECT id, username, password FROM staff_accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the staff account exists
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify the password using password_verify
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables and redirect to index page
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;

            // Fetch the avatar_url and rank from the staff_accounts table and set them in the session
            $stmt = $con->prepare("SELECT avatar_url, rank FROM staff_accounts WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($avatar_url, $rank);
            $stmt->fetch();
            $_SESSION['avatar_url'] = $avatar_url;
            $_SESSION['rank'] = $rank;

            // Close the statement and connection
            $stmt->close();
            mysqli_close($con);

            header("Location: index.php");
            exit;
        } else {
            // Password is incorrect
            $login_error = "Falsches Passwort.";
        }
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($con);
}
?>
<?php
if (isset($login_error)) {
    echo '<p class="error-message">' . $login_error . '</p>';
}
?>
