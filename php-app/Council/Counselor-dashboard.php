<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    header("Location: ../login.php?error=unauthorized");
    exit();
}

require_once "../db/config.php";

// === FETCH DASHBOARD DATA ===
try {
    $totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
    $completedSurveys = $pdo->query("SELECT COUNT(DISTINCT student_id) FROM survey_answers")->fetchColumn();

    $pendingSurveysStmt = $pdo->query("
        SELECT COUNT(*) FROM students 
        WHERE id NOT IN (SELECT DISTINCT student_id FROM survey_answers)
    ");
    $pendingSurveys = $pendingSurveysStmt->fetchColumn();

    // Fetch unsubmitted students
    $unsubmittedStmt = $pdo->query("
        SELECT id, full_name, grade_level, section, strand
        FROM students
        WHERE id NOT IN (SELECT DISTINCT student_id FROM survey_answers)
    ");
    $unsubmittedStudents = $unsubmittedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Top recommended courses
    $courseCounts = [];
    $stmt = $pdo->query("
        SELECT recommended_career, COUNT(*) AS count 
        FROM ai_recommendations 
        GROUP BY recommended_career 
        ORDER BY count DESC
    ");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $courseCounts[$row['recommended_career']] = $row['count'];
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VocAItion Guidance Dashboard</title>
<?php include '../Includes/header.php';?>
<style>
.card-container {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}
.card {
  flex: 1;
  cursor: pointer;
}
.modal {
  display: none;
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
}
.modal-content {
  background: #fff;
  margin: 5% auto;
  padding: 20px;
  border-radius: 8px;
  max-width: 700px;
}
.modal-content table {
  width: 100%;
  border-collapse: collapse;
}
.modal-content th, .modal-content td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: center;
}
.close {
  float: right;
  font-size: 20px;
  cursor: pointer;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<?php include '../Includes/sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- HEADER -->
    <header class="dashboard-header">
        <h1>Welcome, Guidance Counselor!</h1>
    </header>

    <!-- DASHBOARD CARDS -->
    <div class="card-container">
        <!-- Total Students -->
        <div class="card text-center shadow-sm"
             onclick="window.location.href='CounselorManageStudents.php'"
             style="border-radius: 12px; padding: 20px; background-color: #fff; color: #002147;">
            <h3 style="font-size: 1.2rem; font-weight: 600;">Total Students</h3>
            <p style="font-size: 1.8rem; font-weight: bold; margin: 0;"><?= htmlspecialchars($totalStudents) ?></p>
        </div>

        <!-- Submitted Surveys -->
        <div class="card text-center shadow-sm"
             onclick="window.location.href='CareerReportCouncil.php'"
             style="border-radius: 12px; padding: 20px; background-color: #fff; color: #002147;">
            <h3 style="font-size: 1.2rem; font-weight: 600;">Submitted Surveys</h3>
            <p style="font-size: 1.8rem; font-weight: bold; margin: 0;"><?= htmlspecialchars($completedSurveys) ?></p>
        </div>

        <!-- Unsubmitted Surveys -->
        <div class="card text-center shadow-sm"
             onclick="openUnsubmittedModal()"
             style="border-radius: 12px; padding: 20px; background-color: #fff; color: #002147;">
            <h3 style="font-size: 1.2rem; font-weight: 600;">Unsubmitted Surveys</h3>
            <p style="font-size: 1.8rem; font-weight: bold; margin: 0;"><?= htmlspecialchars($pendingSurveys) ?></p>
        </div>
    </div>

    <!-- ADDITIONAL ACTION CARDS -->
    <div class="card-container" style="margin-top: 25px;">
        <a href="validate_list.php" class="card text-center shadow-sm"
           style="border-radius: 12px; padding: 20px; background-color: #ffc107; color: #000; text-decoration:none;">
            <h3 style="font-size: 1.2rem; font-weight: 600;">Validate Results</h3>
            <p style="margin:0; font-size:1rem;">Review AI predictions</p>
        </a>

        <a href="validation_history.php" class="card text-center shadow-sm"
           style="border-radius: 12px; padding: 20px; background-color: #ffc107; color: #fff; text-decoration:none;">
            <h3 style="font-size: 1.2rem; font-weight: 600;">Validation History</h3>
            <p style="margin:0; font-size:1rem;">Validated Records</p>
        </a>
    </div>

    <!-- COURSE CHART -->
    <div class="card" style="margin-top: 25px;">
        <h3>Top Recommended Courses</h3>
        <canvas id="courseChart"></canvas>
    </div>
</div>

<!-- Unsubmitted Surveys Modal -->
<div id="unsubmittedModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeUnsubmittedModal()">&times;</span>
    <h3>Unsubmitted Surveys</h3>
    <table>
      <thead>
        <tr style="background:#ffc107; color:#1d3557;">
          <th>Name</th><th>Grade</th><th>Section</th><th>Strand</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($unsubmittedStudents)): ?>
          <?php foreach ($unsubmittedStudents as $stu): ?>
            <tr>
              <td><?= htmlspecialchars($stu['full_name']) ?></td>
              <td><?= htmlspecialchars($stu['grade_level']) ?></td>
              <td><?= htmlspecialchars($stu['section']) ?></td>
              <td><?= htmlspecialchars($stu['strand']) ?></td>
              <td><a href="submit_survey.php?student_id=<?= $stu['id'] ?>" class="btn btn-sm btn-primary">Submit</a></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5">All students have submitted surveys.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function openUnsubmittedModal() {
  document.getElementById('unsubmittedModal').style.display = 'block';
}
function closeUnsubmittedModal() {
  document.getElementById('unsubmittedModal').style.display = 'none';
}

// Chart.js
const courseLabels = <?php echo json_encode(array_keys($courseCounts)); ?>;
const courseData = <?php echo json_encode(array_values($courseCounts)); ?>;
new Chart(document.getElementById('courseChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: courseLabels,
        datasets: [{
            label: 'Students Recommended',
            data: courseData,
            backgroundColor: courseLabels.map(() => '#8B5E3C'),
            borderColor: '#ffc107',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Most Recommended Courses', font: { size: 16 } }
        },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Sidebar toggle
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');
toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('collapsed');
  mainContent.classList.toggle('collapsed-adjust');
});
</script>

<?php include '../Includes/footer.php'; ?>
</body>
</html>
