<?php
function save_message($username, $avatar_url, $message) {
    $servername = 'localhost';
    $db_username = 'root';
    $password = '';
    $database = 'webdev';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $db_username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO chat_messages (username, avatar_url, message) VALUES (?, ?, ?)");
        $stmt->execute([$username, $avatar_url, $message]);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function get_messages($reverse = false) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'webdev';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT username, avatar_url, message, timestamp FROM chat_messages ORDER BY timestamp DESC";
        $stmt = $conn->query($sql);

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $messages;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
