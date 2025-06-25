<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // No password for default WAMP
define('DB_NAME', 'ecommerce_db');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Try setting utf8mb4 first, then fallback to utf8
// if (!$conn->set_charset("utf8mb4")) {
//     // Log the utf8mb4 failure
//     error_log("utf8mb4 not supported: " . $conn->error);
    
//     // Try fallback to utf8
// }
if (!$conn->set_charset("utf8")){
        die("Error loading character set utf8: " . $conn->error);
    }

?>
