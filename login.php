<?php
session_start();
require_once 'db/config.php'; // Ensure $pdo is defined

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = trim($_POST['identifier']); // LRN or Faculty ID
    $password   = $_POST['password'];
    $role       = $_POST['role']; // 'student' or 'counselor'

    try {
        if ($role === 'student') {
            $stmt = $pdo->prepare("
                SELECT u.id AS user_id, u.password, u.role, u.student_id,
                       s.id AS student_id_check, s.lrn, s.full_name
                FROM users u
                INNER JOIN students s ON u.student_id = s.id
                WHERE s.lrn = ? AND s.status = 'Active'
                LIMIT 1
            ");
        } elseif ($role === 'counselor') {
            $stmt = $pdo->prepare("
                SELECT u.id AS user_id, u.password, u.role, u.counselor_id,
                       g.id AS counselor_id_check, g.faculty_id, g.full_name
                FROM users u
                INNER JOIN guidance_council g ON u.counselor_id = g.id
                WHERE g.faculty_id = ? AND g.status = 'Active'
                LIMIT 1
            ");
        } else {
            throw new Exception("Invalid role selected.");
        }

        $stmt->execute([$identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] === 'student') {
                $_SESSION['student_id']   = $user['student_id']; // used in survey and career path
                $_SESSION['lrn']          = $user['lrn'];
                $_SESSION['student_name'] = $user['full_name'];
                header("Location: Student/Student-dashboard.php");
            } elseif ($user['role'] === 'counselor') {
                $_SESSION['counselor_id']   = $user['counselor_id'];
                $_SESSION['faculty_id']     = $user['faculty_id'];
                $_SESSION['counselor_name'] = $user['full_name'];
                header("Location: Council/Counselor-dashboard.php");
            }
            exit();
        } else {
            header("Location: index.php?error=Invalid credentials or not approved yet");
            exit();
        }

    } catch (Exception $e) {
        header("Location: index.php?error=" . urlencode("Login failed: " . $e->getMessage()));
        exit();
    }
}
?>