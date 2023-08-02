<?php
// Function to get the database connection
function get_connection() {
    $host = 'localhost';
    $dbname = 'webdev';
    $username = 'root';
    $password = '';
    try {
        $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to create the database and the 'users' table
function create_database_and_table() {
    $con = get_connection();

    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS webdev";
    $con->exec($sql);

    // Select the database
    $con->exec("USE webdev");

    // Create the 'users' table with additional fields
    $sql = "CREATE TABLE IF NOT EXISTS user_logs (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        browser VARCHAR(255) NOT NULL,
        os VARCHAR(255) NOT NULL,
        ip_address VARCHAR(50) NOT NULL,
        dnt_header TINYINT(1) NOT NULL,
        local_storage VARCHAR(50) NOT NULL,
        session_storage VARCHAR(50) NOT NULL,
        cookies TEXT NOT NULL,
        language VARCHAR(50) NOT NULL,
        referrer VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $con->exec($sql);
    $con = null;
}

// Function to save user information to the database
function save_user_info($username, $browser, $os, $ip_address, $dnt_header, $local_storage, $session_storage, $cookies, $language, $referrer) {
    $con = get_connection();
    
    $query = "INSERT INTO user_logs (username, browser, os, ip_address, dnt_header, local_storage, session_storage, cookies, language, referrer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->execute([$username, $browser, $os, $ip_address, $dnt_header, $local_storage, $session_storage, $cookies, $language, $referrer]);
    $con = null;
}

// Gather user information
$username = ""; // Populate this if you have the user's username
$browser = $_SERVER['HTTP_USER_AGENT'];
$os = php_uname('s');
$ip_address = $_SERVER['REMOTE_ADDR'];
$dnt_header = isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] === '1' ? 1 : 0;
$local_storage = isset($_SERVER['HTTP_LOCAL_STORAGE']) ? $_SERVER['HTTP_LOCAL_STORAGE'] : 'Not Supported';
$session_storage = isset($_SERVER['HTTP_SESSION_STORAGE']) ? $_SERVER['HTTP_SESSION_STORAGE'] : 'Not Supported';
$cookies = isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : 'Not Found';
$language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'Not Found';
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Not Found';

// Create the database and table
create_database_and_table();

// Save user information to the database
save_user_info($username, $browser, $os, $ip_address, $dnt_header, $local_storage, $session_storage, $cookies, $language, $referrer);
?>
