<?php
require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch latest record per student
$stmt = $pdo->query("
  SELECT s.full_name, s.grade_level,
         rs.realistic, rs.investigative, rs.artistic, rs.social, rs.enterprising, rs.conventional, rs.top_3_types, rs.created_at,
         ar.recommended_career, ar.confidence_score, ar.date_generated
  FROM (
    SELECT sa.*
    FROM survey_answers sa
    INNER JOIN (
      SELECT student_id, MAX(created_at) AS latest
      FROM survey_answers
      GROUP BY student_id
    ) latest_sa ON sa.student_id = latest_sa.student_id AND sa.created_at = latest_sa.latest
  ) sa
  JOIN students s ON s.id = sa.student_id
  JOIN riasec_scores rs ON rs.answer_id = sa.id
  JOIN ai_recommendations ar ON ar.survey_id = sa.id
  ORDER BY ar.date_generated DESC
");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('RIASEC Report');

// Header row
$headers = [
  'Student Name', 'Grade Level', 'Realistic', 'Investigative', 'Artistic', 'Social',
  'Enterprising', 'Conventional', 'RIASEC Code', 'Recommended Career', 'Confidence (%)', 'Date Generated'
];
$sheet->fromArray($headers, null, 'A1');

// Data rows
$rowNum = 2;
foreach ($results as $row) {
  $sheet->setCellValue("A{$rowNum}", $row['full_name']);
  $sheet->setCellValue("B{$rowNum}", $row['grade_level']);
  $sheet->setCellValue("C{$rowNum}", $row['realistic']);
  $sheet->setCellValue("D{$rowNum}", $row['investigative']);
  $sheet->setCellValue("E{$rowNum}", $row['artistic']);
  $sheet->setCellValue("F{$rowNum}", $row['social']);
  $sheet->setCellValue("G{$rowNum}", $row['enterprising']);
  $sheet->setCellValue("H{$rowNum}", $row['conventional']);
  $sheet->setCellValue("I{$rowNum}", $row['top_3_types']);
  $sheet->setCellValue("J{$rowNum}", $row['recommended_career']);
  $sheet->setCellValue("K{$rowNum}", $row['confidence_score']);
  $sheet->setCellValue("L{$rowNum}", date('M d, Y', strtotime($row['date_generated'])));
  $rowNum++;
}

// Output to browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RIASEC_Report.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;