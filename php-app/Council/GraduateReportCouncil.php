<?php
require_once __DIR__ . '/../db/config.php';

// Batch filter
$batch_filter = $_GET['batch'] ?? '';
$search = $_GET['search'] ?? '';

// Get available batch years
$batch_stmt = $pdo->query("SELECT DISTINCT YEAR(created_at) AS batch_year FROM students ORDER BY batch_year DESC");
$batches = $batch_stmt->fetchAll(PDO::FETCH_COLUMN);

// Query students who graduated (status = 'Graduated')
$sql = "SELECT id, full_name, grade_level, strand, email, created_at 
        FROM students 
        WHERE status = 'Graduated'";
$params = [];

if ($batch_filter) {
    $sql .= " AND YEAR(created_at) = :batch";
    $params[':batch'] = $batch_filter;
}

if ($search) {
    $sql .= " AND full_name LIKE :search";
    $params[':search'] = "%$search%";
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
<?php include '../Includes/header.php';?>
<style>
/* MAIN CONTENT */
.main-content {
  flex: 1;
  padding: 30px;
}
h1 {
  font-weight: 600;
  margin-bottom: 20px;
  color: #b08968;
}

/* SEARCH BAR */
.search-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 20px;
}
.search-bar .form-select,
.search-bar .form-control {
  max-width: 220px;
  border: 2px solid #ffc107;
}
.search-bar .filter-btn {
  background-color: #1d3557;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 8px 14px;
}
.search-bar .filter-btn:hover {
  background-color: #27496d;
}

/* TABLE */
.table-container {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
.table thead {
  background-color: #ffc107;
  color: #1d3557;
}
.table-striped tbody tr:nth-of-type(odd) {
  background-color: #fdf6e3;
}
.table td,
.table th {
  vertical-align: middle;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  body {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
    flex-direction: row;
    justify-content: space-around;
  }
}
</style>
</head>
<body>

<!-- SIDEBAR -->
  <?php include '../Includes/sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
  <h1>🎓 Graduate Report</h1>

  <form method="get" class="search-bar">
    <select name="batch" class="form-select">
      <option value="">All Batches</option>
      <?php foreach ($batches as $year): ?>
        <option value="<?= htmlspecialchars($year) ?>" <?= $batch_filter == $year ? 'selected' : '' ?>>
          Batch <?= htmlspecialchars($year) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="filter-btn btn"><i class="bi bi-funnel"></i> Filter</button>
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
<?php include '../Includes/footer.php';?>
</body>
</html>
