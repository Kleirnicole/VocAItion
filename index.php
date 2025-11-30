<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    header("Location: ../login.php?error=unauthorized");
    exit();
}

require_once __DIR__ . '/../db/config.php';

// Get filter from query string
$filterYear = $_GET['school_year'] ?? '';
$sortBy = $_GET['sort'] ?? 'full_name';

// Build query dynamically
$sql = "SELECT id, lrn, full_name, email, birthdate, gender, grade_level, section, guardian_contact, status, profile_image, strand, career_choice, school_year, updated_at, created_at 
        FROM students";

if ($filterYear) {
    $sql .= " WHERE school_year = :school_year";
}

$sql .= " ORDER BY $sortBy ASC";

$stmt = $pdo->prepare($sql);
if ($filterYear) {
    $stmt->bindParam(':school_year', $filterYear);
}
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct school years for dropdown
$yearsStmt = $pdo->query("SELECT DISTINCT school_year FROM students ORDER BY school_year DESC");
$schoolYears = $yearsStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Students | VocAItion</title>
<?php include '../Includes/header.php';?>
</head>
<body>
<?php include '../Includes/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Manage Students</h1>
      <div class="d-flex gap-2">
          <!-- School Year Filter -->
          <form method="GET" class="d-flex gap-2">
              <select name="school_year" class="form-select">
                  <option value="">All Batches</option>
                  <?php foreach ($schoolYears as $year): ?>
                      <option value="<?= htmlspecialchars($year) ?>" 
                          <?= $filterYear === $year ? 'selected' : '' ?>>
                          <?= htmlspecialchars($year) ?>
                      </option>
                  <?php endforeach; ?>
              </select>

              <!-- Sort By -->
              <select name="sort" class="form-select">
                  <option value="full_name" <?= $sortBy==='full_name'?'selected':'' ?>>Name</option>
                  <option value="school_year" <?= $sortBy==='school_year'?'selected':'' ?>>School Year</option>
                  <option value="grade_level" <?= $sortBy==='grade_level'?'selected':'' ?>>Grade</option>
                  <option value="section" <?= $sortBy==='section'?'selected':'' ?>>Section</option>
                  <option value="career_choice" <?= $sortBy==='career_choice'?'selected':'' ?>>Career Choice</option>
              </select>

              <button type="submit" class="btn btn-primary">Apply</button>
          </form>

          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
              <i class="bi bi-person-plus"></i> Add Student
          </button>
      </div>
  </div>

    <table class="table table-hover" id="studentsTable">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Grade Level</th>
            <th>Strand</th>
            <th>Career Choice</th>
            <th>S.Y</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $student): ?>
        <tr id="studentRow<?= $student['id'] ?>">
            <td><?= htmlspecialchars($student['full_name']) ?></td>
            <td><?= htmlspecialchars($student['grade_level']) ?></td>
            <td><?= htmlspecialchars($student['strand']) ?></td>
            <td><?= htmlspecialchars($student['career_choice'] ?? 'Undecided') ?></td>
            <td><?= htmlspecialchars($student['school_year'] ?? '-') ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td class="actions">
                <button class="btn btn-sm btn-info text-white viewBtn" data-student='<?= json_encode($student) ?>'><i class="bi bi-eye"></i> View</button>
                <button class="btn btn-sm btn-warning editBtn" data-student='<?= json_encode($student) ?>'><i class="bi bi-pencil-square"></i> Edit</button>
                <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $student['id'] ?>"><i class="bi bi-trash"></i> Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- ADD STUDENT MODAL -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="addStudentForm">
        <div class="modal-header">
          <h5 class="modal-title">Create Student Account</h5>
        </div>
        <div class="modal-body">
          <h5 class="mb-3">Student Details</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="text" name="student_lrn" class="form-control" placeholder="LRN" required>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="student_full_name" class="form-control" placeholder="Full Name (e.g., Cruz, Juan T.)" required>
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" name="student_email" class="form-control" placeholder="Email">
            </div>
            <div class="col-md-6 mb-3">
              <div class="d-flex align-items-center">
                <label for="student_birthdate" class="form-label me-2 mb-0" style="white-space: nowrap;">Birthdate</label>
                <input type="date" name="student_birthdate" id="student_birthdate" class="form-control flex-grow-1" max="2012-01-01">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <select name="student_gender" class="form-select" required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <select name="student_grade_level" class="form-select" required>
                <option value="">Grade Level</option>
                <option>12</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="student_section" class="form-control" placeholder="Section">
            </div>
            <div class="col-md-6 mb-3">
              <select name="student_strand" class="form-select" required>
                <option value="">Select Strand</option>
                <option>GAS</option>
                <option>STEM</option>
                <option>ARTS & DESIGN</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" name="student_guardian_contact" class="form-control"
                placeholder="Guardian Contact (e.g., 09+...)" 
                pattern="^09\d{9}$" maxlength="11" inputmode="numeric"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                title="Must be 11 digits starting with 09">
            </div>
            <div class="col-md-6 mb-3 position-relative">
              <input type="password" name="password" id="password" class="form-control" placeholder="Temporary Password" required>
              <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
              <small class="text-muted">Counselor sets this. Students must change it after first login.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Create Account</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- VIEW / EDIT MODAL (Dynamic) -->
<div class="modal fade" id="dynamicModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="dynamicModalBody"></div>
            <div class="modal-footer" id="dynamicModalFooter"></div>
        </div>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>
</body>
</html>
