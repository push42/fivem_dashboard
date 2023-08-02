<?php
// Database containing your webserver / where you want to store the database for the webserver
function connect_webserver_db() {
    $servername = 'localhost';
    $db_username = 'root';
    $password = '';
    $database = 'webdev';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $db_username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Database containing fivem gameserver database
function connect_fivem_db() {
    $servername = 'localhost';
    $db_username = 'root';
    $password = '';
    $database = 'db_fivemtest';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $db_username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
