<?php
session_start();
require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../db/audit_log.php';

$id = $_GET['id'] ?? 0;

// ✅ Make sure counselor is logged in
if (!isset($_SESSION['faculty_id'])) {
    exit('Unauthorized access.');
}

// === Fetch report data first ===
$stmt = $pdo->prepare("
    SELECT 
        s.full_name AS student_name, 
        s.strand, 
        ar.recommended_career, 
        ar.date_generated
    FROM ai_recommendations ar
    JOIN survey_answers sa ON ar.survey_id = sa.id
    JOIN students s ON s.id = sa.student_id
    WHERE ar.id = ?
");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) exit('Report not found.');

// ✅ Get counselor full name
$counselor_stmt = $pdo->prepare("SELECT full_name FROM guidance_council WHERE faculty_id = ?");
$counselor_stmt->execute([$_SESSION['faculty_id']]);
$counselor = $counselor_stmt->fetchColumn() ?: 'Unknown Counselor';

// ✅ Log the print action
addAuditLog(
    $_SESSION['faculty_id'],
    "print_report",
    "Career Report",
    "{$counselor} printed report for student {$data['student_name']}"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Career Report</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 40px; }
    h2 { text-align: center; margin-bottom: 20px; }
    .info { margin-top: 20px; }
    .footer { margin-top: 50px; font-size: 14px; color: #555; text-align: right; }
  </style>
</head>
<body onload="window.print()">
  <h2>Career Report</h2>
  <div class="info">
    <p><strong>Name:</strong> <?= htmlspecialchars($data['student_name']) ?></p>
    <p><strong>Strand:</strong> <?= htmlspecialchars($data['strand']) ?></p>
    <p><strong>Recommended Career:</strong> <?= htmlspecialchars($data['recommended_career']) ?></p>
    <p><strong>Date Generated:</strong> <?= date('M d, Y', strtotime($data['date_generated'])) ?></p>
  </div>

  <div class="footer">
    Printed by: <strong><?= htmlspecialchars($counselor) ?></strong>
  </div>
</body>
</html>
