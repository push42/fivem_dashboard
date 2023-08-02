<?php
include "db_config.php";

try {
    $conn = connect_webserver_db();
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
