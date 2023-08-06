<?php
$servername = 'localhost';
$db_username = 'root';
$password = '';
$database = 'webdev';

$conn = new mysqli($servername, $db_username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    // Toggle the completion status in the database
    $sql = 'UPDATE todo_tasks SET completed = NOT completed WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $taskId);
    if ($stmt->execute()) {
        $response = ['success' => true];
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Failed to toggle task completion'];
        echo json_encode($response);
    }
} else {
    $response = ['success' => false, 'message' => 'Task ID not provided'];
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
