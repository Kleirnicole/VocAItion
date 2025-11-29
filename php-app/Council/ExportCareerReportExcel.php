<?php
require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$strand_filter = $_GET['strand'] ?? '';
$course_filter = $_GET['course'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$sql = "
  SELECT 
    ar.id AS report_id,
    s.full_name,
    s.strand,
    ar.recommended_career,
    ar.confidence_score,
    ar.date_generated
  FROM ai_recommendations ar
  JOIN survey_answers sa ON ar.survey_id = sa.id
  JOIN students s ON s.id = sa.student_id
  WHERE 1=1
";

$params = [];

if ($strand_filter) {
  $sql .= " AND s.strand = :strand";
  $params[':strand'] = $strand_filter;
}
if ($course_filter) {
  $sql .= " AND ar.recommended_career LIKE :course";
  $params[':course'] = "%$course_filter%";
}
if ($start_date && $end_date) {
  $sql .= " AND ar.date_generated BETWEEN :start AND :end";
  $params[':start'] = $start_date;
  $params[':end'] = $end_date;
}

$sql .= " ORDER BY ar.date_generated DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Career Report');

// Header
$sheet->fromArray(['Report ID', 'Student', 'Strand', 'Recommended Career', 'Confidence', 'Date'], NULL, 'A1');

// Data
$row = 2;
foreach ($results as $r) {
  $sheet->setCellValue("A{$row}", $r['report_id']);
  $sheet->setCellValue("B{$row}", $r['full_name']);
  $sheet->setCellValue("C{$row}", $r['strand']);
  $sheet->setCellValue("D{$row}", $r['recommended_career']);
  $sheet->setCellValue("E{$row}", $r['confidence_score'] . '%');
  $sheet->setCellValue("F{$row}", date('M d, Y', strtotime($r['date_generated'])));
  $row++;
}

// Output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="CustomCareerReport.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
