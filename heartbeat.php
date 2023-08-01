<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    $con = mysqli_connect("localhost", "root", "", "webdev");
    
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $con->prepare("UPDATE online_users SET last_seen = NOW() WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $stmt->close();
    mysqli_close($con);
}
?>
