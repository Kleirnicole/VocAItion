<?php
require_once __DIR__ . '/../db/config.php';

$stmt = $pdo->query("
  SELECT s.full_name, s.grade_level,
         rs.realistic, rs.investigative, rs.artistic, rs.social, rs.enterprising, rs.conventional,
         rs.top_3_types, rs.created_at,
         ar.recommended_career, ar.confidence_score, ar.date_generated
  FROM (
    SELECT sa.*
    FROM survey_answers sa
    INNER JOIN (
      SELECT student_id, MAX(created_at) AS latest
      FROM survey_answers
      GROUP BY student_id
    ) latest_sa ON sa.student_id = latest_sa.student_id AND sa.created_at = latest_sa.latest
  ) sa
  JOIN students s ON s.id = sa.student_id
  JOIN riasec_scores rs ON rs.answer_id = sa.id
  JOIN ai_recommendations ar ON ar.survey_id = sa.id
  ORDER BY ar.date_generated DESC
");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Survey Results | VocAItion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../Includes/header.php';?>
  <style>

/* MAIN CONTENT */

.flex-grow-1 {
  padding: 30px;
}
h1 {
  color: #b08968;
  font-weight: 600;
}
.input-group .form-control {
  border: 2px solid #ffc107;
}
.btn-warning {
  background-color: #ffc107;
  color: #1d3557;
  font-weight: 600;
}
.btn-success {
  background-color: #1d3557;
  border: none;
}
.btn-success:hover {
  background-color: #27496d;
}
.table-warning {
  background-color: #fff3cd;
  color: #1d3557;
}
.table-bordered th,
.table-bordered td {
  border-color: #dee2e6;
}
.trait-cell {
  font-weight: bold;
  color: #b08968;
}
.score-cell {
  color: #1d3557;
  font-weight: 500;
}
.career-cell {
  font-weight: bold;
  color: #e63946;
}

.table-container {
  max-height: 70vh;
  overflow-y: auto;
  border-radius: 8px;
}

.table thead.sticky-top th {
  background-color: #fff3cd;
  z-index: 2;
}
  </style>
</head>
<body class="d-flex">
<?php include '../Includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4">
    <h1 class="mb-4" style="color: #b08968;">Survey Results Overview</h1>

    <div class="mb-4">
      <div class="input-group input-group-md">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name, RIASEC code, or trait...">
        <button class="btn btn-warning" type="button" onclick="filterTable()">Search</button>
      </div>
    </div>

    <div class="table-container" style="max-height: 70vh; overflow-y: auto;">
  <div class="mb-3 text-end">
    <form action="RIASEC_Report.php" method="post">
      <button type="submit" class="btn btn-success">📥 Download RIASEC Excel Report</button>
    </form>
  </div>
  <table class="table table-bordered table-hover align-middle mb-0">
    <thead class="table-warning sticky-top">
      <tr>
        <th>Student Name</th>
        <th>Grade</th>
        <th>Realistic</th>
        <th>Investigative</th>
        <th>Artistic</th>
        <th>Social</th>
        <th>Enterprising</th>
        <th>Conventional</th>
        <th>RIASEC Code</th>
        <th>Date Generated</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['grade_level']) ?></td>
          <td class="score-cell"><?= $row['realistic'] ?></td>
          <td class="score-cell"><?= $row['investigative'] ?></td>
          <td class="score-cell"><?= $row['artistic'] ?></td>
          <td class="score-cell"><?= $row['social'] ?></td>
          <td class="score-cell"><?= $row['enterprising'] ?></td>
          <td class="score-cell"><?= $row['conventional'] ?></td>
          <td class="trait-cell"><?= htmlspecialchars($row['top_3_types']) ?></td>
          <td class="score-cell"><?= date('M d, Y', strtotime($row['date_generated'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
  </div>

  <script>
    const searchInput = document.getElementById('searchInput');

    function filterTable() {
      const filter = searchInput.value.toLowerCase();
      const rows = document.querySelectorAll('table tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
      });
    }

    searchInput.addEventListener('keyup', function(e) {
      if (e.key === 'Enter') filterTable();
    });
  </script>
  <?php include '../Includes/footer.php';?>
</body>
</html>