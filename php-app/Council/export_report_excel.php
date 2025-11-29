<?php
session_start();
require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../db/audit_log.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// ✅ Log the Excel download action
addAuditLog(
    $_SESSION['faculty_id'],
    "download_excel",
    "Career Report",
    "{$counselor} downloaded Excel for student {$data['student_name']}"
);

// === Generate Excel file ===
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Full Name');
$sheet->setCellValue('B1', 'Strand');
$sheet->setCellValue('C1', 'Recommended Career');
$sheet->setCellValue('D1', 'Date Generated');
$sheet->setCellValue('E1', 'Downloaded By');

$sheet->fromArray(
    [$data['student_name'], $data['strand'], $data['recommended_career'], $data['date_generated'], $counselor],
    NULL,
    'A2'
);

// === Output Excel File ===
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=CareerReport_{$id}.xlsx");
$writer->save('php://output');
exit;
?>
