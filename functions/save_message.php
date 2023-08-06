<?php
// Include the chat_functions.php
include 'functions/chat_functions.php';

// Check if the request is an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Get the data sent from JavaScript
    $username = $_POST['username'];
    $avatar_url = $_POST['avatar_url'];
    $message = $_POST['message'];

    // Call the save_message() function to save the chat message
    save_message($username, $avatar_url, $message);

    // Send a response to indicate success
    echo 'Message saved successfully';
} else {
    echo 'Invalid request';
}
?>
