<?php
// Function to save a chat message to the database
function save_message($username, $avatar_url, $message) {
    $servername = 'localhost';
    $db_username = 'root';
    $password = '';
    $database = 'webdev';

    // Create a database connection
    $connection = new mysqli($servername, $db_username, $password, $database);

    // Check if the connection was successful
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO chat_messages (username, avatar_url, message) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("sss", $username, $avatar_url, $message);

    // Execute the prepared statement
    $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $connection->close();
}



// Function to get chat messages from the database
function get_messages($reverse = false) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'webdev';

    // Create a database connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check if the connection was successful
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT username, avatar_url, message, timestamp FROM chat_messages ORDER BY timestamp DESC";

    $result = $connection->query($sql);

    // Create an array to store the chat messages
    $messages = array();

    // Fetch the results and store them in the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $message = array(
                'username' => $row['username'],
                'avatar_url' => $row['avatar_url'],
                'message' => $row['message'],
                'timestamp' => $row['timestamp']
            );
            $messages[] = $message;
        }
    }

    // Close the result and the database connection
    $result->close();
    $connection->close();

    return $messages;
}


?>
