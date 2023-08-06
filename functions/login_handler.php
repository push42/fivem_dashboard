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
    // Connection information
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "webdev";

    try {
        $con = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitize the user input
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute the SELECT statement
        $stmt = $con->prepare("SELECT id, username, password FROM staff_accounts WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Check if the staff account exists
        if ($user) {
            $hashed_password = $user['password'];
            
            // Verify the password using password_verify
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Fetch the avatar_url and rank from the staff_accounts table
                $stmt_avatar = $con->prepare("SELECT avatar_url, rank FROM staff_accounts WHERE username = ?");
                $stmt_avatar->execute([$username]);
                $user_avatar = $stmt_avatar->fetch();
                $_SESSION['avatar_url'] = $user_avatar['avatar_url'];
                $_SESSION['rank'] = $user_avatar['rank'];

                // Insert username and avatar into online users
                $stmt_online_user = $con->prepare("INSERT INTO online_users (username, avatar_url) VALUES (?, ?)");
                $stmt_online_user->execute([$_SESSION['username'], $_SESSION['avatar_url']]);

                header("Location: index.php");
                exit;
            } else {
                // Password is incorrect
                $login_error = "Falsches Passwort.";
            }
        }

    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
<?php
if (isset($login_error)) {
    echo '<p class="error-message">' . $login_error . '</p>';
}
?>
