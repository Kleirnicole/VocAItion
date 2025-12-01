<?php
require_once __DIR__ . '/config.php';

function addAuditLog($user_id, $action, $resource, $details = '') {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO audit_logs (user_id, action, resource, details, created_at)
        VALUES (:user_id, :action, :resource, :details, NOW())
    ");
    $stmt->execute([
        ':user_id' => $user_id,
        ':action' => $action,
        ':resource' => $resource,
        ':details' => $details
    ]);
}
