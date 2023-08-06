<?php
$servername = 'localhost';
$db_username = 'root';
$password = '';
$database = 'webdev';

$conn = new mysqli($servername, $db_username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['task'])) {
    $task = $_POST['task'];

    $sql = 'INSERT INTO todo_tasks (task) VALUES (?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $task);
    if ($stmt->execute()) {
        $response = ['success' => true, 'taskId' => $stmt->insert_id];
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Failed to save task'];
        echo json_encode($response);
    }
} else {
    $response = ['success' => false, 'message' => 'Task not provided'];
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
