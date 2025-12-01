<?php
session_start();
require_once "../db/config.php";

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

// --- Stats ---
$totalAssessments = $pdo->query("SELECT COUNT(*) FROM riasec_scores")->fetchColumn();
$activeStudents   = $pdo->query("SELECT COUNT(*) FROM students WHERE status='active'")->fetchColumn();

// --- RIASEC totals ---
$riasecStmt = $pdo->query("
    SELECT 
      SUM(realistic) AS Realistic,
      SUM(investigative) AS Investigative,
      SUM(artistic) AS Artistic,
      SUM(social) AS Social,
      SUM(enterprising) AS Enterprising,
      SUM(conventional) AS Conventional
    FROM riasec_scores
");
$riasecTotals = $riasecStmt->fetch(PDO::FETCH_ASSOC);
$riasecLabelsJSON = json_encode(array_keys($riasecTotals));
$riasecDataJSON   = json_encode(array_values($riasecTotals));

// --- Top RIASEC Types ---
$topTypeStmt = $pdo->query("SELECT top_3_types FROM riasec_scores");
$topTypeCounts = ['R'=>0,'I'=>0,'A'=>0,'S'=>0,'E'=>0,'C'=>0];
while($row = $topTypeStmt->fetch(PDO::FETCH_ASSOC)){
    $types = explode(',', $row['top_3_types']);
    foreach($types as $t){
        $t = trim($t);
        if(isset($topTypeCounts[$t])){
            $topTypeCounts[$t]++;
        }
    }
}
$courseLabels = array_keys($topTypeCounts);
$courseData   = array_values($topTypeCounts);
$courseLabelsJSON = json_encode($courseLabels);
$courseDataJSON   = json_encode($courseData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Courses | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
    <?php include '../Includes/admin-sidebar.php'; ?>
<div class="container">

  <h3>Course & RIASEC Overview</h3>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card text-center p-3">
        <div class="card-header small-muted">Total Assessments</div>
        <div class="stat-value"><?= $totalAssessments ?></div>
        <div class="small-muted">Completed RIASEC tests</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <div class="card-header small-muted">Active Students</div>
        <div class="stat-value"><?= $activeStudents ?></div>
        <div class="small-muted">Registered users</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <div class="card-header small-muted">Top RIASEC Type</div>
        <div class="stat-value"><?= $courseLabels[array_search(max($courseData), $courseData)] ?></div>
        <div class="small-muted">Most common type</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <div class="card-header small-muted">Types Tracked</div>
        <div class="stat-value"><?= count($courseLabels) ?></div>
        <div class="small-muted">RIASEC dimensions</div>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card chart-card">
        <div class="card-header">RIASEC Distribution</div>
        <canvas id="riasecChart" height="220"></canvas>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card chart-card">
        <div class="card-header">Top RIASEC Types</div>
        <canvas id="courseChart" height="220"></canvas>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card mt-4">
    <div class="card-header">RIASEC Types Count Table</div>
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Type</th>
            <th>Count</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($topTypeCounts as $type=>$count): ?>
          <tr>
            <td><?= htmlspecialchars($type) ?></td>
            <td><?= htmlspecialchars($count) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
const riasecCtx = document.getElementById('riasecChart').getContext('2d');
new Chart(riasecCtx,{
    type:'pie',
    data:{ 
        labels: <?= $riasecLabelsJSON ?>,
        datasets:[{ 
            data: <?= $riasecDataJSON ?>,
            backgroundColor:['#3B82F6','#10B981','#F59E0B','#EF4444','#6366F1','#14B8A6']
        }]
    },
    options:{ plugins:{ legend:{ position:'bottom' } } }
});

const courseCtx = document.getElementById('courseChart').getContext('2d');
new Chart(courseCtx,{
    type:'bar',
    data:{
        labels: <?= $courseLabelsJSON ?>,
        datasets:[{
            label:'Suggestions Count',
            data: <?= $courseDataJSON ?>,
            backgroundColor: '#2563EB',
            borderRadius:6
        }]
    },
    options:{ scales:{ y:{ beginAtZero:true } }, plugins:{ legend:{ display:false } } }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
