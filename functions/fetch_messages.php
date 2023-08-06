<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'webdev';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT COUNT(*) AS totalMessages FROM chat_messages");
    $totalMessages = $stmt->fetchColumn();

    $response = [
      'totalMessages' => $totalMessages
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
