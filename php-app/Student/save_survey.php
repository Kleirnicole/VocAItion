<?php
session_start();
require_once "../db/config.php";

// Validate session
if (!isset($_SESSION['student_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Ensure student_id is numeric
if (!is_numeric($student_id)) {
    echo "<h3>Error: Invalid student ID.</h3>";
    exit();
}

// Verify student exists
$check = $pdo->prepare("SELECT COUNT(*) FROM students WHERE id = ?");
$check->execute([$student_id]);
if ($check->fetchColumn() == 0) {
    echo "<h3>Error: Student ID $student_id not found in database.</h3>";
    exit();
}

// Collect survey answers
$answers = [];
for ($i = 1; $i <= 42; $i++) {
    $q = "q$i";
    $answers[$q] = isset($_POST[$q]) ? $_POST[$q] : '';
}

// Validate minimum input
if (empty(array_filter($answers))) {
    echo "<h3>Error: No survey answers submitted.</h3>";
    exit();
}

// --- Insert survey_answers into DB (same as your current code) ---
// ... keep your existing DB insert + audit log logic ...

// Calculate RIASEC scores
$groups = [
    'realistic'     => ['q1','q7','q14','q22','q30','q32','q37'],
    'investigative' => ['q2','q11','q18','q21','q26','q33','q39'],
    'artistic'      => ['q3','q8','q17','q23','q27','q31','q41'],
    'social'        => ['q4','q12','q13','q20','q28','q34','q40'],
    'enterprising'  => ['q5','q10','q16','q19','q29','q36','q42'],
    'conventional'  => ['q6','q9','q15','q24','q25','q35','q38'],
];

$scores = [];
foreach ($groups as $type => $questions) {
    $scores[$type] = array_reduce($questions, function($sum, $q) use ($answers) {
        return $sum + (isset($answers[$q]) && strtolower($answers[$q]) === 'yes' ? 1 : 0);
    }, 0);
}

arsort($scores);
$top_3 = array_slice(array_keys($scores), 0, 3);
$top_3_str = implode(',', array_map(fn($t) => strtoupper(substr($t, 0, 1)), $top_3));
$_SESSION['top_3_types'] = $top_3_str;

// Add RIASEC code to answers for JSON
$answers['top_3_types'] = $top_3_str;
$answers['code'] = $top_3_str;

// --- Call Python API via HTTP ---
$url = "https://your-python-service.up.railway.app/predict"; // replace with actual Railway URL

$options = [
    "http" => [
        "header" => "Content-Type: application/json",
        "method" => "POST",
        "content" => json_encode($answers),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo "<h3>Error: Could not connect to AI service.</h3>";
    exit();
}

$result = json_decode($response, true);

// Save results to session
$_SESSION['recommended_course'] = $result['recommended_course'] ?? null;
$_SESSION['recommended_score'] = $result['recommended_score'] ?? null;
$_SESSION['suggested_course'] = $result['suggested_course'] ?? null;
$_SESSION['suggested_score'] = $result['suggested_score'] ?? null;
$_SESSION['recommended_description'] = $result['recommended_description'] ?? null;

// Redirect to AI suggestions page
header("Location: Studentai-suggestions.php");
exit();
?>