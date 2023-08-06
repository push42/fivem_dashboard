<?php
include 'functions/chat_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $avatar_url = $_POST['avatar_url'];
    $message = $_POST['message'];

    save_message($username, $avatar_url, $message);

    echo 'Message saved successfully';
} else {
    echo 'Invalid request';
}
?>
