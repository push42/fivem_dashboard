<?php
session_start();

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "webdev");

    // Check if the connection was successful
    if (!$con) {
        die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
    }

    // Check which form was submitted
    if (isset($_POST['update_avatar'])) {
        // Update Avatar

        // Sanitize the user input to prevent SQL injection
        $new_avatar_url = mysqli_real_escape_string($con, $_POST['new_avatar_url']);
        $user_id = $_SESSION['id'];

        // Prepare and execute the UPDATE statement to update the avatar_url
        $stmt = $con->prepare("UPDATE staff_accounts SET avatar_url = ? WHERE id = ?");
        $stmt->bind_param("si", $new_avatar_url, $user_id);

        if ($stmt->execute()) {
            // Update successful
            $_SESSION['avatar_url'] = $new_avatar_url; // Update the session variable as well
            header("Location: index.php"); // Redirect back to the index page
            exit;
        } else {
            // Update failed
            $update_error = "Fehler beim Aktualisieren des Avatars. Bitte versuchen Sie es erneut.";
        }

        // Close the statement
        $stmt->close();
    } elseif (isset($_POST['update_username'])) {
        // Update Username

        // Sanitize the user input to prevent SQL injection
        $new_username = mysqli_real_escape_string($con, $_POST['new_username']);
        $user_id = $_SESSION['id'];

        // Check if the new username is available
        $stmt = $con->prepare("SELECT id FROM staff_accounts WHERE username = ?");
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username already taken
            $update_error = "Der Benutzername ist bereits vergeben.";
        } else {
            // Prepare and execute the UPDATE statement to update the username
            $stmt = $con->prepare("UPDATE staff_accounts SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $new_username, $user_id);

            if ($stmt->execute()) {
                // Update successful
                $_SESSION['username'] = $new_username; // Update the session variable
                header("Location: index.php"); // Redirect back to the index page
                exit;
            } else {
                // Update failed
                $update_error = "Fehler beim Aktualisieren des Benutzernamens. Bitte versuchen Sie es erneut.";
            }
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    mysqli_close($con);
}
?>
