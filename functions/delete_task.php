<?php
include 'db_config.php';

$conn = connect_webserver_db();

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    $sql = 'DELETE FROM todo_tasks WHERE id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$taskId])) {
        $response = ['success' => true];
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Failed to delete task'];
        echo json_encode($response);
    }
} else {
    $response = ['success' => false, 'message' => 'Task ID not provided'];
    echo json_encode($response);
}
?>
