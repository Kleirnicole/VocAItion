<?php
require_once __DIR__ . '/../db/config.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    // Delete student
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if($stmt->execute([$id])){
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
