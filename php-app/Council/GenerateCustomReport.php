<?php
require_once __DIR__ . '/../db/config.php';

// Batch filter
$batch_filter = $_GET['batch'] ?? '';

// Get available batch years (graduates only)
$batch_stmt = $pdo->query("
  SELECT DISTINCT YEAR(created_at) AS batch_year 
  FROM students 
  WHERE status = 'Graduated' 
  ORDER BY batch_year DESC
");
$batches = $batch_stmt->fetchAll(PDO::FETCH_COLUMN);

// Query graduates
$sql = "SELECT id, full_name, grade_level, strand, email, created_at 
        FROM students 
        WHERE status = 'Graduated'";
$params = [];

if (!empty($batch_filter)) {
    $sql .= " AND YEAR(created_at) = :batch";
    $params[':batch'] = $batch_filter;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$graduates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Graduate Report | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
  display: flex;
  min-height: 100vh;
  font-family: 'Poppins', sans-serif;
  background: #f8f9fa;
  color: #1d3557;
}
.sidebar {
  width: 250px;
  background: linear-gradient(180deg, #1d3557 0%, #457b9d 100%);
  color: #fff;
  display: flex;
  flex-direction: column;
  padding: 20px;
}
.sidebar h2 {
  text-align: center;
  margin-bottom: 30px;
  font-weight: 700;
}
.sidebar a {
  display: flex;
  align-items: center;
  color: #fff;
  text-decoration: none;
  padding: 12px 15px;
  border-radius: 8px;
  margin-bottom: 10px;
  transition: background 0.3s;
}
.sidebar a:hover, .sidebar a.active {
  background: rgba(255,255,255,0.2);
}
.main-content {
  flex: 1;
  padding: 30px;
}
h1 {
  font-weight: 600;
  margin-bottom: 20px;
}
.table-container {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.table th {
  background: #1d3557;
  color: #fff;
}
.filter-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.filter-bar select {
  max-width: 220px;
}
button.filter-btn {
  background-color: #1d3557;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 8px 14px;
}
button.filter-btn:hover {
  background-color: #16325c;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>VocAItion</h2>
  <a href="Counselor-Dashboard.php"><i class="bi bi-house-door me-2"></i>Dashboard</a>
  <a href="CouselorSurveyResults.php"><i class="bi bi-clipboard-data me-2"></i>Survey Results</a>
  <a href="CareerReportCouncil.php"><i class="bi bi-bar-chart-line me-2"></i>Career Reports</a>
  <a href="GraduateReportCouncil.php" class="active"><i class="bi bi-mortarboard me-2"></i>Graduate Report</a>
  <a href="CounselorManageStudents.php"><i class="bi bi-people me-2"></i>Manage Students</a>
  <a href="../Council/council-profile.php"><i class="bi bi-person-circle me-2"></i>Profile</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <h1>🎓 Graduate Report</h1>

  <form method="get" class="filter-bar">
    <select name="batch" class="form-select">
      <option value="">All Batches</option>
      <?php foreach ($batches as $year): ?>
        <option value="<?= htmlspecialchars($year) ?>" <?= $batch_filter == $year ? 'selected' : '' ?>>
          Batch <?= htmlspecialchars($year) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="filter-btn">
      <i class="bi bi-funnel"></i> Filter
    </button>
  </form>

  <div class="table-container">
    <?php if (!empty($graduates)): ?>
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Grade Level</th>
            <th>Strand</th>
            <th>Email</th>
            <th>Batch Year</th>
            <th>Date Added</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($graduates as $i => $g): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($g['full_name']) ?></td>
            <td><?= htmlspecialchars($g['grade_level']) ?></td>
            <td><?= htmlspecialchars($g['strand']) ?></td>
            <td><?= htmlspecialchars($g['email']) ?></td>
            <td><?= date('Y', strtotime($g['created_at'])) ?></td>
            <td><?= date('M d, Y', strtotime($g['created_at'])) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted text-center mb-0">No graduates found for this batch.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
