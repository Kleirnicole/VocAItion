<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load database credentials from Railway environment variables
$host = getenv('DB_HOST') ?: 'shortline.proxy.rlwy.net';
$db   = getenv('DB_NAME') ?: 'railway';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'vkkUABvKKZDmTjuZSHCFPCHbNLzkzqbw';

define('PREDICT_API_URL', 'https://vocaiton-production.up.railway.app/predict');

// Create MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed (MySQLi): " . $conn->connect_error);
}
?>