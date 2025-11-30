<?php
require_once 'db/config.php'; // adjust path as needed

$lrn = $_GET['lrn'] ?? '';
$exists = false;

if ($lrn) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE lrn = ?");
    $stmt->execute([$lrn]);
    $exists = $stmt->fetchColumn() > 0;
}

echo json_encode(['exists' => $exists]);