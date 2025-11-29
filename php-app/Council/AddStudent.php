<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    echo "unauthorized";
    exit();
}

require_once '../db/config.php';

// Collect POST data
$lrn              = trim($_POST['student_lrn'] ?? '');
$full_name        = trim($_POST['student_full_name'] ?? '');
$email            = trim($_POST['student_email'] ?? '');
$password_plain   = $_POST['password'] ?? '';
$birthdate        = $_POST['student_birthdate'] ?? null;
$gender           = $_POST['student_gender'] ?? null;
$grade_level      = $_POST['student_grade_level'] ?? null;
$section          = $_POST['student_section'] ?? null;
$strand           = $_POST['student_strand'] ?? null;
$guardian_contact = $_POST['student_guardian_contact'] ?? null;
$now              = date('Y-m-d H:i:s');

// Validate required fields
if (empty($lrn) || empty($full_name) || empty($password_plain)) {
    echo "missing_fields";
    exit();
}

// Hash password
$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

try {
    // Check duplicate LRN
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE lrn = ?");
    $checkStmt->execute([$lrn]);
    if ($checkStmt->fetchColumn() > 0) {
        echo "lrn_exists";
        exit();
    }

    $pdo->beginTransaction();

    // Insert into students (omit profile_image so MySQL default applies)
    $stmt = $pdo->prepare("
        INSERT INTO students
        (lrn, full_name, email, password, birthdate, gender, grade_level, section, guardian_contact, strand, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, ?)
    ");
    $stmt->execute([
        $lrn,
        $full_name,
        $email,
        $hashed_password,
        $birthdate,
        $gender,
        $grade_level,
        $section,
        $guardian_contact,
        $strand,
        $now,
        $now
    ]);

    $student_id = $pdo->lastInsertId();

    // Insert into users
    $stmt2 = $pdo->prepare("
        INSERT INTO users (email, password, role, student_id, created_at, updated_at)
        VALUES (?, ?, 'student', ?, ?, ?)
    ");
    $stmt2->execute([
        $email,
        $hashed_password,
        $student_id,
        $now,
        $now
    ]);

    $pdo->commit();
    echo "success";

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('AddStudent Error: ' . $e->getMessage());
    echo "failed: " . $e->getMessage();
}