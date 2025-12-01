<?php
session_start();
require_once __DIR__ . '/db/config.php';

// ✅ CSRF protection
if ($_SERVER["REQUEST_METHOD"] !== "POST" 
    || !isset($_POST['csrf_token']) 
    || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid request.");
}

$created_at = date('Y-m-d H:i:s');
$password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

try {
    // Always counselor role
    $faculty_id      = trim($_POST['faculty_id'] ?? '');
    $full_name       = trim($_POST['counselor_full_name'] ?? '');
    $email           = trim($_POST['counselor_email'] ?? '');
    $office_location = trim($_POST['office_location'] ?? '');
    $position        = trim($_POST['position'] ?? '');

    // ✅ Check if Faculty ID already exists in guidance_council table
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM guidance_council WHERE faculty_id = ?");
    $checkStmt->execute([$faculty_id]);
    $facultyExists = $checkStmt->fetchColumn();

    if ($facultyExists > 0) {
        // Redirect back with error
        header("Location: register.php?error=faculty_exists");
        exit();
    }

    // ✅ Insert counselor into pending_registrations
    $stmt = $pdo->prepare("
        INSERT INTO pending_registrations 
        (role, full_name, email, password, faculty_id, office_location, position, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        'counselor',
        $full_name,
        $email,
        $password,
        $faculty_id,
        $office_location,
        $position,
        $created_at
    ]);

    // ✅ Success
    header("Location: register.php?success=pending");
    exit();

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}