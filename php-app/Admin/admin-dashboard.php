<?php include '../Includes/header.php'; ?>
<?php
session_start();
require_once "../db/config.php";

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

// --- Initialize variables ---
$total_assessments = 0;
$total_students = 0;
$recent_assessments = [];
$riasec_counts = [
    'realistic' => 0,
    'investigative' => 0,
    'artistic' => 0,
    'social' => 0,
    'enterprising' => 0,
    'conventional' => 0
];
$avg_ai_accuracy = 0;
$top_course = 'N/A';
$top_courses_data = [];

try {
    // Total RIASEC assessments
    $stmt = $pdo->query("SELECT COUNT(*) FROM riasec_scores");
    $total_assessments = (int) $stmt->fetchColumn();

    // Total active students
    $stmt = $pdo->query("SELECT COUNT(*) FROM students WHERE status='active'");
    $total_students = (int) $stmt->fetchColumn();

    // Latest 5 assessments
    $stmt = $pdo->query("SELECT id, top_3_types, created_at FROM riasec_scores ORDER BY created_at DESC LIMIT 5");
    $recent_assessments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // RIASEC type distribution
    $stmt = $pdo->query("
        SELECT 
            SUM(realistic) AS realistic,
            SUM(investigative) AS investigative,
            SUM(artistic) AS artistic,
            SUM(social) AS social,
            SUM(enterprising) AS enterprising,
            SUM(conventional) AS conventional
        FROM riasec_scores
    ");
    $riasec_counts = $stmt->fetch(PDO::FETCH_ASSOC);

    // Average AI Accuracy
    $stmt = $pdo->query("SELECT AVG(confidence_score) AS avg_accuracy FROM ai_recommendations");
    $avg_ai_accuracy = round((float) $stmt->fetchColumn(), 2);

    // Top suggested course
    $stmt = $pdo->query("
        SELECT recommended_career, COUNT(*) AS total
        FROM ai_recommendations
        GROUP BY recommended_career
        ORDER BY total DESC
        LIMIT 1
    ");
    $top_course_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($top_course_row) $top_course = $top_course_row['recommended_career'];

    // Top 5 courses for linegraph
    $stmt = $pdo->query("
        SELECT recommended_career, COUNT(*) AS total
        FROM ai_recommendations
        GROUP BY recommended_career
        ORDER BY total DESC
        LIMIT 5
    ");
    $top_courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Prepare data for Chart.js
$top_course_labels = json_encode(array_column($top_courses_data, 'recommended_career'));
$top_course_counts = json_encode(array_column($top_courses_data, 'total'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | VocAItion</title>
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

</style>
</head>
<body>
<?php include '../Includes/sidebar.php'; ?>
<aside class="sidebar p-3">
<h4 style="color:var(--brand)">VocAItion</h4>
<div class="small-muted mb-3">AI-Powered Career Path Tool</div>
<nav class="nav flex-column gap-1">
  <a class="nav-link active" href="admin-dashboard.php">🏠 Dashboard</a>
  <a class="nav-link" href="admin-students.php">👩‍🎓 Students</a>
  <a class="nav-link" href="admin-council.php">👩 Council</a>
  <a class="nav-link" href="admin-assesments.php">🧾 Assessments</a>
  <a class="nav-link" href="admin-courses.php">📚 Courses</a>
  <a class="nav-link" href="admin-manage-register.php">👥 Manage Register</a>
  <a class="nav-link" href="admin-reports.php">📊 Reports</a>
  <a class="nav-link" href="admin-audit.php">🕵️ Audit Logs</a>
  <a class="nav-link" href="admin-settings.php">⚙️ Settings</a>
</nav>
<div class="mt-4 small-muted">
  <div>© 2025 VocAItion</div>
  <div>Version 1.0</div>
</div>
</aside>

<main class="main">
<div class="topbar">
  <div><h5 class="mb-0">Admin Dashboard</h5><small class="text-muted">VocAItion — AI Career Path Suggestion</small></div>
  <div class="d-flex align-items-center gap-2">
    <input class="form-control form-control-sm" style="width:200px;" placeholder="Search...">
    <button class="btn btn-outline-secondary btn-sm">🔔</button>
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Admin</button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><a class="dropdown-item" href="../db/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="content">
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card p-3 text-center">
      <div class="small-muted">Total Assessments</div>
      <div class="stat-value"><?= $total_assessments ?></div>
      <div class="small-muted">Completed RIASEC tests</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3 text-center">
      <div class="small-muted">Active Students</div>
      <div class="stat-value"><?= $total_students ?></div>
      <div class="small-muted">Registered users</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3 text-center">
      <div class="small-muted">Top Suggested Course</div>
      <div class="stat-value"><?= htmlspecialchars($top_course) ?></div>
      <div class="small-muted">Most frequent AI suggestion</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3 text-center">
      <div class="small-muted">AI Accuracy</div>
      <div class="stat-value"><?= $avg_ai_accuracy ?>%</div>
      <div class="small-muted">Avg. model confidence</div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>RIASEC Distribution</strong>
        <small class="small-muted">by personality type</small>
      </div>
      <canvas id="riasecChart" height="220"></canvas>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>Top Suggested Courses</strong>
        <small class="small-muted">based on AI results</small>
      </div>
      <canvas id="courseChart" height="220"></canvas>
    </div>
  </div>
</div>

<div class="card p-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <strong>Recent Career Assessments</strong>
    <small class="small-muted">Latest 5 entries</small>
  </div>

  <?php if (!empty($recent_assessments)): ?>
    <table class="table table-bordered table-sm align-middle mt-2">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Top 3 Types</th>
          <th>Date Taken</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recent_assessments as $i => $row): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($row['top_3_types']) ?></td>
            <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info m-2">No student assessments yet — data will appear once students take the RIASEC test.</div>
  <?php endif; ?>
</div>
</div>
</main>

<script>
const ctx1 = document.getElementById('riasecChart').getContext('2d');
new Chart(ctx1, {
  type: 'pie',
  data: {
    labels: ['Realistic','Investigative','Artistic','Social','Enterprising','Conventional'],
    datasets: [{
      data: [
        <?= $riasec_counts['realistic'] ?? 0 ?>,
        <?= $riasec_counts['investigative'] ?? 0 ?>,
        <?= $riasec_counts['artistic'] ?? 0 ?>,
        <?= $riasec_counts['social'] ?? 0 ?>,
        <?= $riasec_counts['enterprising'] ?? 0 ?>,
        <?= $riasec_counts['conventional'] ?? 0 ?>
      ],
      backgroundColor: ['#3B82F6','#10B981','#F59E0B','#EF4444','#6366F1','#14B8A6']
    }]
  },
  options: { plugins: { legend: { position: 'bottom' } } }
});

const ctx2 = document.getElementById('courseChart').getContext('2d');
new Chart(ctx2, {
  type: 'line',
  data: {
    labels: <?= $top_course_labels ?>,
    datasets: [{
      label: 'Top Suggested Courses',
      data: <?= $top_course_counts ?>,
      borderColor: '#2563EB',
      backgroundColor: 'rgba(37,99,235,0.2)',
      fill: true,
      tension: 0.3
    }]
  },
  options: { scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include '../Includes/footer.php'; ?>