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

// Get the most frequent username from the chat_messages table
$sql = "SELECT username, COUNT(*) AS frequency FROM chat_messages GROUP BY username ORDER BY frequency DESC LIMIT 1";
$result = $connection->query($sql);
$mostPresentUsername = '';

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $mostPresentUsername = $row['username'];
}

// Close the connection
$connection->close();

// Return the most present username as a response
echo $mostPresentUsername;
?>
