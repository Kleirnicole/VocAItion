<?php
// Load database credentials from Railway environment variables
$host = getenv('MYSQLHOST') ?: 'localhost';
$db   = getenv('MYSQLDATABASE') ?: 'vocaiton';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';

define('PREDICT_API_URL', 'https://vocaiton-production.up.railway.app/predict');

// Check if PDO MySQL driver is available
if (!in_array('mysql', PDO::getAvailableDrivers())) {
    die("Database connection failed: PDO MySQL driver not installed.");
}

try {
    // Create PDO connection
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Fallback: try mysqli if PDO fails
    $mysqli = @new mysqli($host, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die("Database connection failed: " . $e->getMessage() . 
            " | mysqli error: " . $mysqli->connect_error);
    } else {
        // Optional: expose mysqli as $pdo for compatibility
        $pdo = $mysqli;
    }
}
?>