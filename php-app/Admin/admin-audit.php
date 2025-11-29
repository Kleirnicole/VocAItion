<?php
session_start();
require_once "../db/config.php";

// --- Security check (admin only)
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

// --- Fetch all audit logs
try {
    $stmt = $pdo->query("SELECT * FROM audit_logs ORDER BY created_at DESC");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching audit logs: " . $e->getMessage());
}

// --- Fetch all names
$students = [];
$stmt = $pdo->query("SELECT id, full_name FROM students");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $s) {
    $students[$s['id']] = $s['full_name'];
}

$counselors = [];
$stmt = $pdo->query("SELECT faculty_id, full_name FROM guidance_council");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $c) {
    $counselors[$c['faculty_id']] = $c['full_name'];
}

function safe($val) {
    return htmlspecialchars($val ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function getUserInfo($user_id, $students, $counselors) {
    if (isset($counselors[$user_id])) {
        return ['role' => 'Counselor', 'name' => $counselors[$user_id]];
    } elseif (isset($students[$user_id])) {
        return ['role' => 'Student', 'name' => $students[$user_id]];
    }
    return ['role' => 'Unknown', 'name' => 'Unknown User'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Audit Logs | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
    --primary: #2563EB;
    --secondary: #10B981;
    --bg-light: #F9FAFB;
    --card-bg: #ffffff;
    --muted: #6B7280;
    --shadow: rgba(0,0,0,0.1);
}
body { background: var(--bg-light); font-family:'Inter',sans-serif; margin:0; padding:0; }
.container { max-width: 1200px; margin:2rem auto; }
h3 { color: var(--primary); margin-bottom:1.5rem; font-weight:600; }

.card { border:none; border-radius:12px; box-shadow:0 4px 12px var(--shadow); transition: transform 0.2s; }
.card:hover { transform: translateY(-3px); }
.card-header { font-weight:600; font-size:1.1rem; }
.card-body { padding:1rem 1.5rem; }
.stat-value { font-size:1.6rem; font-weight:700; margin-top:0.3rem; }
.small-muted { color: var(--muted); font-size:0.9rem; }

.chart-card { padding:1.5rem; }

.table-responsive { overflow-x:auto; }
.table th, .table td { vertical-align: middle; }

@media (max-width:768px){
    .stat-value { font-size:1.3rem; }
    .card-header { font-size:1rem; }
    .table th, .table td { font-size:0.85rem; }
}
.sidebar { position:fixed; top:0; left:0; width:230px; height:100vh; background: var(--card-bg); border-right:1px solid #e5e7eb; overflow-y:auto; }
.main { margin-left:230px; height:100vh; display:flex; flex-direction:column; }
.topbar { background: var(--card-bg); height:64px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; padding:0 1rem; position:sticky; top:0; z-index:10; }
.content { flex:1; overflow-y:auto; padding:1.5rem; }
.card { border-radius:10px; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
.small-muted { color: var(--muted); font-size:0.9rem; }
.table-responsive { overflow-x:auto; }
.table th, .table td { vertical-align: middle; }
.sidebar .nav-link { color:#111827; }
.sidebar .nav-link.active { background: rgba(37,99,235,0.1); color: var(--brand); border-radius:6px; }
</style>
</head>
<body>
<?php include '../Includes/admin-sidebar.php';?>
<div class="container">
    <h3>Admin Audit Logs</h3>

    <?php if (empty($logs)): ?>
        <div class="alert alert-info text-center">No audit logs found.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped align-middle text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Action</th>
                    <th>Resource</th>
                    <th>Details</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $i => $row):
                    $user = getUserInfo($row['user_id'], $students, $counselors);
                ?>
                <tr <?php if ($row['action'] === 'login') echo 'class="table-success"'; ?>>
                    <td><?= $i + 1 ?></td>
                    <td><?= safe($user['role']) ?></td>
                    <td><?= safe($user['name']) ?></td>
                    <td><?= safe(ucwords(str_replace('_', ' ', $row['action']))) ?></td>
                    <td><?= safe($row['resource']) ?></td>
                    <td><?= safe($row['details']) ?></td>
                    <td><?= safe(date('M d, Y h:i A', strtotime($row['created_at']))) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
