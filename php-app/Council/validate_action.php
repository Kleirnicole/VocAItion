<?php
session_start();
require_once "../db/config.php";

$ai_id   = $_POST['ai_id'] ?? null;
$student = $_POST['student_id'] ?? null;
$survey  = $_POST['survey_id'] ?? null;
$suggest = $_POST['counselor_suggestion'] ?? null;
$status  = $_POST['status'] ?? null;
$validator = $_SESSION['full_name'] ?? 'Counselor'; // fallback if not set

if (!$ai_id || !$student || !$survey) {
    die("Missing required fields");
}

// Get AI data
$stmt = $pdo->prepare("
    SELECT recommended_career, confidence_score
    FROM ai_recommendations
    WHERE id = ?
");
$stmt->execute([$ai_id]);
$ai = $stmt->fetch();

if (!$ai) {
    die("AI recommendation not found");
}

// Insert or update (upsert)
$save = $pdo->prepare("
    INSERT INTO validation_history
    (ai_id, student_id, survey_id, recommended_career, confidence_score, 
     counselor_suggestion, status, validated_by, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE
        recommended_career = VALUES(recommended_career),
        confidence_score = VALUES(confidence_score),
        counselor_suggestion = VALUES(counselor_suggestion),
        status = VALUES(status),
        validated_by = VALUES(validated_by),
        created_at = NOW()
");

$save->execute([
    $ai_id,
    $student,
    $survey,
    $ai['recommended_career'],
    $ai['confidence_score'],
    $suggest,
    $status,
    $validator
]);

// Redirect back to list
header("Location: validate_list.php?success=validated");
exit();