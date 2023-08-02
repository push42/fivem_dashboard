<?php
include 'db_config.php';

$conn = connect_webserver_db();

$result = $conn->query("SELECT COUNT(*) as count FROM online_users");
$row = $result->fetch(PDO::FETCH_ASSOC);
$online_users_count = $row['count'];

$conn = null;

echo $online_users_count;
?>
