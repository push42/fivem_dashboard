<?php
$servername = 'localhost';
$db_username = 'root';
$password = '';
$database = 'webdev';

$conn = new mysqli($servername, $db_username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = 'SELECT * FROM todo_tasks ORDER BY created_at DESC';
$result = $conn->query($sql);
if ($result === false) {
    $response = ['success' => false, 'message' => 'Error executing the SQL query: ' . $conn->error];
    echo json_encode($response);
    exit;
}

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id' => $row['id'],
            'task' => $row['task'],
            'completed' => (bool)$row['completed'],
        ];
    }
}

$response = ['success' => true, 'tasks' => $tasks];
echo json_encode($response);

$conn->close();
?>
