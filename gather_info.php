<?php
// Function to create the database and the 'users' table
function create_database_and_table() {
    $con = mysqli_connect("localhost", "root", "");
    if (!$con) {
        die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
    }

    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS roguevde_";
    mysqli_query($con, $sql);

    // Select the database
    mysqli_select_db($con, "roguevde_");

    // Create the 'users' table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        browser VARCHAR(255) NOT NULL,
        os VARCHAR(255) NOT NULL,
        ip_address VARCHAR(50) NOT NULL,
        screen_resolution VARCHAR(50) NOT NULL,
        connection_type VARCHAR(50) NOT NULL,
        dnt_header TINYINT(1) NOT NULL,
        local_storage VARCHAR(50) NOT NULL,
        session_storage VARCHAR(50) NOT NULL,
        cookies TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    mysqli_query($con, $sql);
    mysqli_close($con);
}

// Function to save user information to the database
function save_user_info($username, $browser, $os, $ip_address, $screen_resolution, $connection_type, $dnt_header, $local_storage, $session_storage, $cookies) {
    $con = mysqli_connect("localhost", "root", "", "webdev");
    
    if (!$con) {
        die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
    }
    
    $query = "INSERT INTO users (username, browser, os, ip_address, screen_resolution, connection_type, dnt_header, local_storage, session_storage, cookies) VALUES ('$username', '$browser', '$os', '$ip_address', '$screen_resolution', '$connection_type', '$dnt_header', '$local_storage', '$session_storage', '$cookies')";
    mysqli_query($con, $query);
    mysqli_close($con);
}

// Gather user information
$username = "";
$browser = $_SERVER['HTTP_USER_AGENT'];
$os = php_uname('s');
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get user's screen resolution using JavaScript
echo '<script>
    var screenResolution = screen.width + "x" + screen.height;
</script>';

// Get user's connection type using JavaScript
echo '<script>
    var connectionType = navigator.connection ? navigator.connection.type : "Unknown";
</script>';

// Get Do Not Track (DNT) Header
$dnt_header = isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] === '1' ? 1 : 0;

// Get Local Storage
$local_storage = isset($_SERVER['HTTP_LOCAL_STORAGE']) ? $_SERVER['HTTP_LOCAL_STORAGE'] : 'Not Supported';

// Get Session Storage
$session_storage = isset($_SERVER['HTTP_SESSION_STORAGE']) ? $_SERVER['HTTP_SESSION_STORAGE'] : 'Not Supported';

// Get Cookies
$cookies = isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : 'Not Found';

// Create the database and table
create_database_and_table();

// Save user information to the database
save_user_info($username, $browser, $os, $ip_address, $screenResolution, $connectionType, $dnt_header, $local_storage, $session_storage, $cookies);
?>
