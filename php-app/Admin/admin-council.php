<?php
session_start();
require_once "../db/config.php";

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM guidance_council ORDER BY created_at DESC");
$counselors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Counselors | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>🧑‍🏫 Counselor List</h4>  
  </div>

  <table class="table table-bordered table-hover align-middle">
    <thead>
      <tr>
        <th>Faculty ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Position</th>
        <th>Office Location</th>
        <th>Date Added</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($counselors): foreach ($counselors as $i => $c): ?>
      <tr>
        <td><?= htmlspecialchars($c['faculty_id']) ?></td>
        <td><?= htmlspecialchars($c['full_name']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars($c['position']) ?></td>
        <td><?= htmlspecialchars($c['office_location']) ?></td>
        <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
      </tr>
      <?php endforeach; else: ?>
      <tr><td colspan="7" class="text-center text-muted">No counselors found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
