<?php
// Load database credentials from Railway environment variables
$host = getenv('MYSQLHOST') ?: 'shortline.proxy.rlwy.net';
$db   = getenv('MYSQLDATABASE') ?: 'railway';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'vkkUABvKKZDmTjuZSHCFPCHbNLzkzqbw';

define('PREDICT_API_URL', 'https://vocaiton-production.up.railway.app/predict');

// Create MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed (MySQLi): " . $conn->connect_error);
}
?>