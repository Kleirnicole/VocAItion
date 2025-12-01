<?php
session_start();
require_once 'config.php'; // Ensure this uses PDO connection as $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    // Common fields
    $role       = $_POST['role'];
    $email      = $_POST['email'];
    $full_name  = $_POST['full_name'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');

    try {
        $pdo->beginTransaction();

        if ($role === 'student') {
            // Insert into students table
            $stmt = $pdo->prepare("
                INSERT INTO students (
                    lrn, full_name, email, birthdate, gender, grade_level, section,
                    guardian_contact, strand, status, created_at, updated_at
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, ?
                )
            ");
            $stmt->execute([
                $_POST['lrn'],
                $full_name['full_name'],
                $email['email'],
                $_POST['birthdate'],
                $_POST['gender'],
                $_POST['grade_level'],
                $_POST['section'],
                $_POST['guardian_contact'],
                $_POST['strand'],
                $created_at,
                $created_at
            ]);
            $student_id = $pdo->lastInsertId();

            // Insert into users table
            $stmt = $pdo->prepare("
                INSERT INTO users (
                    email, password, role, student_id, created_at, updated_at
                ) VALUES (?, ?, 'student', ?, ?, ?)
            ");
            $stmt->execute([
                $email,
                $password,
                $student_id,
                $created_at,
                $created_at
            ]);

        } elseif ($role === 'counselor') {
            // Insert into guidance_council table
            $stmt = $pdo->prepare("
                INSERT INTO guidance_council (
                    faculty_id, full_name, email, office_location, position,
                    status, created_at, updated_at
                ) VALUES (?, ?, ?, ?, ?, 'active', ?, ?)
            ");
            $stmt->execute([
                $_POST['faculty_id'],
                $full_name['full_name'],
                $email['email'],
                $_POST['office_location'],
                $_POST['position'],
                $created_at,
                $created_at
            ]);
            $counselor_id = $pdo->lastInsertId();

            // Insert into users table
            $stmt = $pdo->prepare("
                INSERT INTO users (
                    email, password, role, counselor_id, created_at, updated_at
                ) VALUES (?, ?, 'counselor', ?, ?, ?)
            ");
            $stmt->execute([
                $email,
                $password,
                $counselor_id,
                $created_at,
                $created_at
            ]);
        }

        $pdo->commit();
        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Registration failed: " . $e->getMessage());
    }
}
?>