<?php
// get_messages.php

// Include the chat_functions.php file to access the get_messages() function
include 'functions/chat_functions.php';

// Fetch the chat messages from the database in reverse order (newest messages first)
$messages = get_messages(true);

// Return the chat messages as a JSON response
header('Content-Type: application/json');
echo json_encode($messages);
?>
