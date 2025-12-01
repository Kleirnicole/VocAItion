<?php
ob_clean();
session_start();
require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../db/audit_log.php';
require_once __DIR__ . '/../tcpdf/tcpdf.php';

$id = $_GET['id'] ?? 0;

// ✅ Make sure counselor is logged in
if (!isset($_SESSION['faculty_id'])) {
    exit('Unauthorized access.');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ✅ Fetch full report data including chart values
$stmt = $pdo->prepare("
    SELECT 
        ar.survey_id,
        s.full_name AS student_name,
        s.lrn,
        s.strand,
        s.gender,
        s.birthdate,
        s.grade_level,
        s.section,
        ar.recommended_career,
        ar.recommended_description,
        ar.suggested_career,
        ar.confidence_score,
        ar.suggested_score,
        ar.date_generated,
        ri.realistic AS r_realistic,
        ri.investigative,
        ri.artistic,
        ri.social AS r_social,
        ri.enterprising,
        ri.conventional,
        ri.top_3_types
    FROM ai_recommendations ar
    JOIN survey_answers sa ON ar.survey_id = sa.id
    JOIN students s ON s.id = sa.student_id
    JOIN riasec_scores ri ON ri.answer_id = sa.id
    WHERE ar.id = ?
");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$skillScores = [];
$skillMap = [
    'Communication' => ['q10', 'q12', 'q31', 'q34', 'q42'],
    'Teamwork' => ['q4', 'q13', 'q40'],
    'Problem Solving' => ['q2', 'q11', 'q21', 'q26'],
    'Initiative' => ['q5', 'q19', 'q36'],
    'Planning & Organizing' => ['q6', 'q9', 'q24', 'q35'],
    'Self-Management' => ['q3', 'q15', 'q32'],
    'Learning Agility' => ['q18', 'q28', 'q33', 'q39'],
    'Technology Literacy' => ['q1', 'q7', 'q22']
];

$survey_stmt = $pdo->prepare("SELECT * FROM survey_answers WHERE id = ?");
$survey_stmt->execute([$data['survey_id']]);
$answers = $survey_stmt->fetch(PDO::FETCH_ASSOC);

foreach ($skillMap as $skill => $questions) {
    $yesCount = 0;
    foreach ($questions as $q) {
        if (isset($answers[$q]) && strtolower($answers[$q]) === 'yes') {
            $yesCount++;
        }
    }
    $score = round(($yesCount / count($questions)) * 10);
    $skillScores[$skill] = $score;
}

if (!$data) exit('Report not found.');

// ✅ Get counselor full name
$counselor_stmt = $pdo->prepare("SELECT full_name FROM guidance_council WHERE faculty_id = ?");
$counselor_stmt->execute([$_SESSION['faculty_id']]);
$counselor = $counselor_stmt->fetchColumn() ?: 'Unknown Counselor';

// ✅ Log the download action
addAuditLog(
    $_SESSION['faculty_id'],
    "download_pdf",
    "Career Report",
    "{$counselor} downloaded PDF for student {$data['student_name']}"
);

// === PDF Setup ===
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('VocAItion System');
$pdf->SetAuthor('VocAItion');
$pdf->SetTitle('Career Report');
$pdf->SetMargins(20, 20, 20);
$pdf->AddPage();

// === Optional Logo ===
// $pdf->Image(__DIR__ . '/../assets/logo.png', 20, 10, 25);

function addHeader($pdf) {
    $logoPath = __DIR__ . '/../Council/sagayNHS_logo.png';

    // Logo and school name in one line
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 20, 12, 18); // x=20, y=12, width=18mm
    }

    $pdf->SetXY(45, 14); // Align school name beside logo
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 8, "SAGAY NATIONAL HIGH SCHOOL", 0, 1, 'L');

    // Centered report title below
    $pdf->SetY(32);
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 10, "Career Recommendation Report", 0, 1, 'C');
    $pdf->Ln(4); // Margin below title
}

function addStudentProfile($pdf, $data, $counselor) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 8,
        "Name: {$data['student_name']}\n" .
        "LRN: {$data['lrn']}\n" .
        "Strand: {$data['strand']}\n" .
        "Grade Level: {$data['grade_level']}\n" .
        "Section: {$data['section']}\n" .
        "Gender: {$data['gender']}\n" .
        "Birthdate: {$data['birthdate']}\n" .
        "Date Generated: {$data['date_generated']}\n" .
        "Downloaded by: {$counselor}",
    0, 'L', false);
    $pdf->Ln(5);
}

function addCareerRecommendation($pdf, $data) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "Career Recommendation Summary", 0, 1);

    $pdf->SetFont('helvetica', '', 11);
    $pdf->MultiCell(0, 8,
        "Recommended Career: {$data['recommended_career']}\n" .
        "Confidence Score: {$data['confidence_score']}\n" .
        "Description: {$data['recommended_description']}\n\n" .
        "Suggested Career: {$data['suggested_career']}\n" .
        "Suggested Score: {$data['suggested_score']}",
    0, 'L', false);
    $pdf->Ln(5);
}

function drawBarChart($pdf, $title, $data, $xStart, $yStart) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetXY($xStart, $yStart);
    $pdf->Cell(0, 6, $title, 0, 1);

    $barHeight = 4;
    $maxWidth = 100;
    $maxValue = max($data);

    if ($maxValue == 0) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetXY($xStart, $yStart += 6);
        $pdf->Cell(0, 6, "No data available.", 0, 1);
        return $yStart + 10;
    }

    $pdf->SetFont('helvetica', '', 10);
    foreach ($data as $label => $value) {
        $barWidth = ($value / $maxValue) * $maxWidth;
        $pdf->SetXY($xStart, $yStart += 6);
        $pdf->Cell(30, $barHeight, $label, 0, 0);
        $pdf->SetFillColor(100, 149, 237); // Cornflower Blue
        $pdf->Rect($xStart + 35, $yStart, $barWidth, $barHeight, 'F');
        $pdf->Cell(0, $barHeight, " {$value}", 0, 1);
    }
    return $yStart + 10;
}

function addRIASECSection($pdf, $data) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "RIASEC Code Breakdown", 0, 1);

    $pdf->SetFont('helvetica', '', 11);
    $pdf->MultiCell(0, 8,
        "Realistic: {$data['r_realistic']}\n" .
        "Investigative: {$data['investigative']}\n" .
        "Artistic: {$data['artistic']}\n" .
        "Social: {$data['r_social']}\n" .
        "Enterprising: {$data['enterprising']}\n" .
        "Conventional: {$data['conventional']}\n" .
        "Top 3 Types: {$data['top_3_types']}",
    0, 'L', false);
    $pdf->Ln(10);
}

function addFooter($pdf) {
    $pdf->SetY($pdf->getPageHeight() - 31); // 15mm from bottom
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->SetTextColor(120, 120, 120); // Slightly muted gray
    $pdf->Cell(0, 10, 'Generated by VocAItion System', 0, 0, 'C');
}

// === Render PDF Sections ===
addHeader($pdf);
addStudentProfile($pdf, $data, $counselor);
addCareerRecommendation($pdf, $data);

// ✅ Add formatted RIASEC Code before charts
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell(0, 8, "RIASEC Interest Code", 0, 1);

$pdf->SetFont('helvetica', '', 10);
$code = strtoupper($data['top_3_types'] ?? '');
$letters = str_split($code);
$formatted = '(' . implode(', ', $letters) . ')';
$pdf->MultiCell(0, 6, "RIASEC Code: {$formatted}", 0, 'L', false);
$pdf->Ln(4);

// ✅ Chart Data
$careerInterests = [
    "Realistic"     => $data['r_realistic']     ?? 0,
    "Investigative" => $data['investigative']   ?? 0,
    "Artistic"      => $data['artistic']        ?? 0,
    "Social"        => $data['r_social']        ?? 0,
    "Enterprising"  => $data['enterprising']    ?? 0,
    "Conventional"  => $data['conventional']    ?? 0
];

$skills = $skillScores;

// ✅ Draw charts stacked vertically with reduced size
$yStart = $pdf->GetY();
$chartHeight1 = drawBarChart($pdf, "RIASEC Test Strengths", $careerInterests, 20, $yStart);
$chartHeight2 = drawBarChart($pdf, "Career Readiness Skills", $skills, 20, $chartHeight1 + 2);

// ✅ Force footer to bottom of page
$pdf->SetY($pdf->getPageHeight() - 40);
addFooter($pdf);

$pdf->Output("CareerReport_{$id}.pdf", 'D');
exit;