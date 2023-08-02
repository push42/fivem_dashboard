<?php
$con = mysqli_connect("localhost", "root", "", "webdev");
if (!$con) {
    die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
}

$result = mysqli_query($con, "SELECT COUNT(*) as count FROM online_users");
$row = mysqli_fetch_assoc($result);
$online_users_count = $row['count'];
mysqli_close($con);

echo $online_users_count;
?>
