<?php
session_start();

$role = $_POST['role'];
$id_number = $_POST['id_number'];
$password = $_POST['password'];
$action = $_POST['action'];

$data = http_build_query([
    'role' => $role,
    'id_number' => $id_number,
    'password' => $password
]);

$url = ($action === 'login') 
    ? 'http://localhost:8000/api/login/' 
    : 'http://localhost:8000/api/register/';

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $data,
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);

if ($response['status'] === 'success') {
    $_SESSION['role'] = $response['role'];
    if ($response['role'] === 'student') {
        header("Location: student/Student-Dashboard.php");
    } elseif ($response['role'] === 'counselor') {
        header("Location: council/Counselor-dashboard.php");
    }
    exit();
} elseif ($response['status'] === 'registered') {
    header("Location: index.php?success=1");
    exit();
} else {
    header("Location: index.php?error=" . urlencode($response['message']));
    exit();
}
?>