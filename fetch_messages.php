<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'webdev';

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
  die('Connection failed: ' . $connection->connect_error);
}

// Get the total number of messages from the chat_messages table
$sql = "SELECT COUNT(*) AS totalMessages FROM chat_messages";
$result = $connection->query($sql);
$totalMessages = 0;

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalMessages = (int)$row['totalMessages'];
}

// Close the connection
$connection->close();

// Return the total number of messages as a JSON response
$response = [
  'totalMessages' => $totalMessages
];
echo json_encode($response);
?>
