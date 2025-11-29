<?php
require_once __DIR__ . '/../db/config.php';

// Get filter values
$selected_year = $_GET['year'] ?? '';
$search        = isset($_GET['search']) ? trim($_GET['search']) : '';
$page          = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit         = 10; // reports per page
$offset        = ($page - 1) * $limit;

$sort = $_GET['sort'] ?? 'date'; // default sort by date

// Sorting options
switch ($sort) {
  case 'name':
    $orderBy = "s.full_name ASC";
    break;
  case 'confidence':
    $orderBy = "ar.confidence_score DESC";
    break;
  default:
    $orderBy = "ar.date_generated DESC";
}

// --- Determine latest school year ---
$latestYearStmt = $pdo->query("SELECT MAX(s.school_year) FROM students s");
$latestYear = $latestYearStmt->fetchColumn();

// --- Generate continuous 5 school years starting from latest ---
$schoolYears = [];
if ($latestYear) {
    list($start, $end) = explode('-', $latestYear);
    for ($i = 0; $i < 5; $i++) {
        $syStart = (int)$start - $i;
        $syEnd   = (int)$end - $i;
        $schoolYears[] = $syStart . '-' . $syEnd;
    }
}

// Build query
$sql = "
  SELECT 
    ar.id AS report_id,
    s.full_name,
    s.grade_level,
    s.section,
    s.strand,
    s.career_choice,          -- student's own career choice
    ar.recommended_career,    -- AI recommended career
    ar.date_generated,
    rs.top_3_types,
    ar.confidence_score,
    s.school_year
  FROM ai_recommendations ar
  JOIN survey_answers sa ON ar.survey_id = sa.id
  JOIN students s ON s.id = sa.student_id
  JOIN riasec_scores rs ON rs.answer_id = sa.id
  WHERE ar.date_generated = (
    SELECT MAX(ar2.date_generated)
    FROM ai_recommendations ar2
    JOIN survey_answers sa2 ON ar2.survey_id = sa2.id
    WHERE sa2.student_id = sa.student_id
  )
";

$params = [];
if (!empty($selected_year)) {
  $sql .= " AND s.school_year = :year";
  $params[':year'] = $selected_year;
}

if (!empty($search)) {
  $sql .= " AND (s.full_name LIKE :search 
             OR s.section LIKE :search 
             OR s.strand LIKE :search 
             OR s.career_choice LIKE :search 
             OR ar.recommended_career LIKE :search)";
  $params[':search'] = "%$search%";
}

$sql .= " ORDER BY $orderBy LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Count total reports for pagination ---
$countSql = "
  SELECT COUNT(*)
  FROM ai_recommendations ar
  JOIN survey_answers sa ON ar.survey_id = sa.id
  JOIN students s ON s.id = sa.student_id
  WHERE ar.date_generated = (
    SELECT MAX(ar2.date_generated)
    FROM ai_recommendations ar2
    JOIN survey_answers sa2 ON ar2.survey_id = sa2.id
    WHERE sa2.student_id = sa.student_id
  )
";
if (!empty($selected_year)) {
  $countSql .= " AND s.school_year = :year";
}
if (!empty($search)) {
  $countSql .= " AND (s.full_name LIKE :search 
             OR ar.recommended_career LIKE :search 
             OR s.strand LIKE :search 
             OR s.section LIKE :search 
             OR s.career_choice LIKE :search)";
}
$countStmt = $pdo->prepare($countSql);
foreach ($params as $key => $val) {
    $countStmt->bindValue($key, $val);
}
$countStmt->execute();
$totalReports = $countStmt->fetchColumn();
$totalPages   = ceil($totalReports / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Career Reports - VocAItion</title>
  <?php include '../Includes/header.php';?>
  <style>
/* MAIN CONTENT */
.main-content {
  flex: 1;
  padding: 30px;
  overflow-y: auto;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 10px;
}
.header h1 {
  color: #b08968;
  font-weight: 600;
}

/* FILTER BAR */
.filter-bar {
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}
.filter-bar input,
.filter-bar select {
  padding: 8px;
  border: 2px solid #ffc107;
  border-radius: 6px;
  max-width: 400px;
}
.filter-bar button {
  background: #ffc107;
  color: #1d3557;
  font-weight: 600;
  border: 2px solid #8e6b3e;
  border-radius: 6px;
  padding: 8px 14px;
}
.filter-bar button:hover {
  background: #1d3557;
  color: #fff;
  border-color: #ffc107;
}

/* TABLE */
table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}
thead {
  background: #ffc107;
  color: #1d3557;
}
th, td {
  padding: 7px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
tbody tr:hover {
  background: #fdf6e3;
}

/* ACTION BUTTONS */
.action-btns button {
  padding: 6px 10px;
  border: none;
  border-radius: 2px;
  cursor: pointer;
  margin: 1px;
  color: #fff;
}
.pdf { background: #e63946; }
.excel { background: #2a9d8f; }
.print { background: #1d3557; }

/* PAGINATION */
.pagination .page-link {
  color: #1d3557;
  border: 1px solid #8e6b3e;
}
.pagination .page-item.active .page-link {
  background-color: #ffc107;
  border-color: #ffc107;
  color: #1d3557;
  font-weight: bold;
}
.pagination .page-link:hover {
  background-color: #1d3557;
  color: #fff;
  border-color: #ffc107;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  table { font-size: 13px; }
}

  </style>
</head>
<body>
  <?php include '../Includes/sidebar.php'; ?>

  <div class="main-content">
  <div class="header">
    <h1>Career Reports</h1>
    
    <!-- School Year Dropdown in upper right -->
    <form method="get" class="d-flex gap-2">
      <select name="year" class="form-select">
        <option value="">-- All School Years --</option>
        <?php foreach ($schoolYears as $sy): ?>
          <option value="<?= $sy ?>" <?= $selected_year == $sy ? 'selected' : '' ?>>
            <?= $sy ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-sm btn-primary">Apply</button>
    </form>
  </div>

  <!-- Filter Bar with Sorting + Search -->
  <form method="get" class="filter-bar">
    <select name="sort" class="form-select">
      <option value="date" <?= $sort == 'date' ? 'selected' : '' ?>>Sort by Date</option>
      <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Sort by Name</option>
      <option value="confidence" <?= $sort == 'confidence' ? 'selected' : '' ?>>Sort by Confidence</option>
    </select>

    <input type="text" name="search" 
           placeholder="Search by Name, Section, Strand, Career"
           value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit" class="btn"><i class="fas fa-search"></i> Search</button>
  </form>

  <!-- Reports Table -->
  <table>
    <thead>
      <tr>
        <th>Full Name</th>
        <th>Grade</th>
        <th>Section</th>
        <th>Strand</th>
        <th>Career Choice (Student)</th>
        <th>AI Recommended Career</th>
        <th>Confidence</th>
        <th>Date Generated</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($reports)): ?>
        <?php foreach ($reports as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['full_name']) ?></td>
            <td><?= htmlspecialchars($r['grade_level']) ?></td>
            <td><?= htmlspecialchars($r['section']) ?></td>
            <td><?= htmlspecialchars($r['strand']) ?></td>
            <td><?= htmlspecialchars($r['career_choice'] ?? '') ?></td>
            <td><?= htmlspecialchars($r['recommended_career'] ?? '') ?></td>
            <td><?= number_format(($r['confidence_score'] ?? 0), 2) ?>%</td>
            <td><?= date('M d, Y', strtotime($r['date_generated'])) ?></td>
            <td class="action-btns">
              <button class="pdf" onclick="downloadPDF(<?= $r['report_id'] ?>)"><i class="fas fa-file-pdf"></i></button>
              <button class="excel" onclick="downloadExcel(<?= $r['report_id'] ?>)"><i class="fas fa-file-excel"></i></button>
              <button class="print" onclick="printReport(<?= $r['report_id'] ?>)"><i class="fas fa-print"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="10" style="text-align:center;">No reports found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <nav class="mt-3">
      <ul class="pagination justify-content-center">
        <!-- Previous -->
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
          <a class="page-link"
             href="?year=<?= urlencode($selected_year) ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&page=<?= max(1, $page-1) ?>">
            Previous
          </a>
        </li>

        <!-- Page Numbers -->
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
          <li class="page-item <?= $p == $page ? 'active' : '' ?>">
            <a class="page-link"
               href="?year=<?= urlencode($selected_year) ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&page=<?= $p ?>">
              <?= $p ?>
            </a>
          </li>
        <?php endfor; ?>
        <!-- Next -->
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link"
             href="?year=<?= urlencode($selected_year) ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&page=<?= min($totalPages, $page+1) ?>">
            Next
          </a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
  </div>
  <script>
    function downloadPDF(id) { window.location.href = "export_report_pdf.php?id=" + id; }
    function downloadExcel(id) { window.location.href = "export_report_excel.php?id=" + id; }
    function printReport(id) { window.open("print_report.php?id=" + id, "_blank"); }
  </script>
  <?php include '../Includes/footer.php';?>
</body>
</html>