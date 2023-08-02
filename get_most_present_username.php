<?php
include 'db_config.php';

$conn = connect_webserver_db();

// Get the most frequent username from the chat_messages table
$sql = "SELECT username, COUNT(*) AS frequency FROM chat_messages GROUP BY username ORDER BY frequency DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mostPresentUsername = $stmt->fetch(PDO::FETCH_ASSOC)['username'];

// Close the connection
$stmt = null;
$conn = null;

// Return the most present username as a response
echo $mostPresentUsername;
?>
