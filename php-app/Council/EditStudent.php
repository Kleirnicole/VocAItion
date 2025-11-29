<?php
require_once __DIR__ . '/../db/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE students SET full_name=?, grade_level=?, strand=?, email=? WHERE id=?");
    $success = $stmt->execute([$_POST['full_name'], $_POST['grade_level'], $_POST['strand'], $_POST['email'], $id]);
    echo $success ? 'success' : 'error';
}
