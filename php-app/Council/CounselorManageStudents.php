<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    header("Location: ../login.php?error=unauthorized");
    exit();
}

require_once __DIR__ . '/../db/config.php';

// --- Determine latest school year (e.g., 2027-2028) ---
$latestYearStmt = $pdo->query("SELECT MAX(school_year) FROM students");
$latestYear = $latestYearStmt->fetchColumn();

// --- Get filters from query string ---
$filterYear   = $_GET['school_year'] ?? $latestYear;
$filterGrade  = $_GET['grade_level'] ?? '';
$filterSearch = isset($_GET['search']) ? trim($_GET['search']) : '';   // unified search (name OR section OR strand)
$page         = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 10; // students per page
$offset       = ($page - 1) * $limit;

// --- Build query dynamically ---
$sql = "SELECT s.id, s.lrn, s.full_name, s.email, s.birthdate, s.gender,
               s.grade_level, s.section, s.guardian_contact, s.status,
               s.profile_image, s.strand, s.school_year, s.updated_at, s.created_at
        FROM students s
        WHERE s.school_year = :school_year";

if ($filterGrade)  $sql .= " AND s.grade_level = :grade_level";
if ($filterSearch) $sql .= " AND (s.full_name LIKE :search OR s.section LIKE :search OR s.strand LIKE :search)";

$sql .= " ORDER BY s.full_name ASC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':school_year', $filterYear);
if ($filterGrade)  $stmt->bindParam(':grade_level', $filterGrade);
if ($filterSearch) $stmt->bindValue(':search', "%$filterSearch%", PDO::PARAM_STR);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Count total students for pagination ---
$countSql = "SELECT COUNT(*)
             FROM students s
             WHERE s.school_year = :school_year";
if ($filterGrade)  $countSql .= " AND s.grade_level = :grade_level";
if ($filterSearch) $countSql .= " AND (s.full_name LIKE :search OR s.section LIKE :search OR s.strand LIKE :search)";

$countStmt = $pdo->prepare($countSql);
$countStmt->bindParam(':school_year', $filterYear);
if ($filterGrade)  $countStmt->bindParam(':grade_level', $filterGrade);
if ($filterSearch) $countStmt->bindValue(':search', "%$filterSearch%", PDO::PARAM_STR);
$countStmt->execute();
$totalStudents = $countStmt->fetchColumn();
$totalPages    = ceil($totalStudents / $limit);

// --- Generate continuous 5 school years starting from latest ---
$schoolYears = [];
list($start, $end) = explode('-', $latestYear);
for ($i = 0; $i < 5; $i++) {
    $syStart = (int)$start + $i;
    $syEnd   = (int)$end + $i;
    $schoolYears[] = $syStart . '-' . $syEnd;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Students | VocAItion</title>
<?php include '../Includes/header.php';?>
<style>
.main-content { flex:1; padding:30px; overflow-x:auto; }
.main-content h1 { font-weight:600; margin-bottom:20px; color:#b08968; }

table { width:100%; background:#fff; border-collapse:collapse; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
th { background:#1d3557; color:#fff; }
td { padding:12px 15px; border-bottom:1px solid #ddd; }
tr:hover { background:#fdf6e3; }

.actions .btn { margin-right:5px; }
.btn-info { background:#1d3557; border:none; color:#fff; }
.btn-info:hover { background:#27496d; }
.btn-warning { background:#ffc107; border:none; color:#1d3557; }
.btn-warning:hover { background:#e0a800; }
.btn-danger { background:#e63946; border:none; color:#fff; }
.btn-danger:hover { background:#c92a3b; }

.modal-header { background:#1d3557; color:#fff; }
.modal-footer .btn-secondary { background:#6c757d; color:#fff; }
.modal-footer .btn-warning { background:#ffc107; color:#1d3557; }
.modal-footer .btn-danger { background:#e63946; color:#fff; }
/* Search Bar Styling */
.search-bar {
    max-width: 400px;       /* medium size */
    border: 2px solid navy; /* navy border */
    border-radius: 6px;
    padding: 8px 12px;
}

.btn-search {
    background-color: #f1c40f; /* warm yellow */
    color: #2c3e50;            /* navy text */
    font-weight: 600;
    border: 2px solid #8e6b3e; /* brown border */
    border-radius: 6px;
    transition: 0.3s;
}

.btn-search:hover {
    background-color: #2c3e50; /* navy hover */
    color: #fff;
    border-color: #f1c40f;     /* yellow border on hover */
}

/* Pagination Styling */
.pagination .page-link {
    color: #2c3e50;            /* navy text */
    border: 1px solid #8e6b3e; /* brown border */
}

.pagination .page-item.active .page-link {
    background-color: #f1c40f; /* yellow active */
    border-color: #f1c40f;
    color: #2c3e50;            /* navy text */
    font-weight: bold;
}

.pagination .page-link:hover {
    background-color: #2c3e50; /* navy hover */
    color: #fff;
    border-color: #f1c40f;
}
</style>
</head>
<body>
<?php include '../Includes/sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Dynamic heading -->
        <h1><?= htmlspecialchars($filterYear) ?> Batch</h1>

        <div class="d-flex gap-2">
            <!-- School Year Dropdown -->
            <form method="GET" class="d-flex gap-2">
                <select name="school_year" class="form-select" onchange="this.form.submit()" style="max-height:150px; overflow-y:auto;">
                    <?php foreach ($schoolYears as $year): ?>
                        <option value="<?= htmlspecialchars($year) ?>" <?= $filterYear === $year ? 'selected' : '' ?>>
                            <?= htmlspecialchars($year) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addStudentModal">
              <i class="bi bi-person-plus"></i> Add Student
          </button>
        </div>
    </div>
<!-- Unified Search -->
<form method="GET" class="mb-3 d-flex justify-content-center">
    <input type="hidden" name="school_year" value="<?= htmlspecialchars($filterYear) ?>">
    <input type="text" name="search" 
           class="form-control search-bar"
           placeholder="Search by Name, Section, or Strand"
           value="<?= htmlspecialchars($filterSearch) ?>">
    <button type="submit" class="btn btn-search ms-2">Search</button>
</form>
   <!-- Students Table -->
<?php if (!empty($students)): ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Grade Level</th>
                <th>Strand</th>
                <th>Section</th>
                <th>S.Y</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['full_name']) ?></td>
                <td><?= htmlspecialchars($student['grade_level']) ?></td>
                <td><?= htmlspecialchars($student['strand']) ?></td>
                <td><?= htmlspecialchars($student['section']) ?></td>
                <td><?= htmlspecialchars($student['school_year']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td>
                    <button class="btn btn-sm btn-info text-white viewBtn" data-student='<?= json_encode($student) ?>'>
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button class="btn btn-sm btn-warning editBtn" data-student='<?= json_encode($student) ?>'>
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $student['id'] ?>">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center">
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                <a class="page-link" 
                   href="?school_year=<?= urlencode($filterYear) ?>&search=<?= urlencode($filterSearch) ?>&grade_level=<?= urlencode($filterGrade) ?>&page=<?= $p ?>">
                   <?= $p ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
    <?php else: ?>
        <p>No students found for <?= htmlspecialchars($filterYear) ?>.</p>
    <?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> 
// ADD Student
$('#addStudentForm').submit(function(e){
    e.preventDefault();

    $.post('AddStudent.php', $(this).serialize(), function(response){
        console.log('AddStudent response:', response); // debug log

        const res = response.trim();
        if (res === 'success') {
            location.reload();
        } else if (res === 'unauthorized') {
            alert('You are not authorized to add students.');
        } else if (res === 'missing_fields') {
            alert('Please fill in all required fields.');
        } else if (res === 'lrn_exists') {
            alert('LRN already exists.');
        } else {
            alert('Failed to add student. Response: ' + response);
        }
    }).fail(function(xhr){
        alert('Request failed: ' + xhr.status + ' ' + xhr.statusText);
    });
});

// DELETE Student
$(document).on('click', '.deleteBtn', function(){
    let id = $(this).data('id');
    if(!id) return alert('Invalid student ID.');
    $.post('DeleteStudent.php', {id:id}, function(response){
        if(response.trim() === 'success'){
            $('#studentRow'+id).remove();
        } else alert('Failed to delete student.');
    });
});

// VIEW / EDIT Dynamic Modal
$(document).on('click', '.viewBtn, .editBtn', function(){
    let student = $(this).data('student');
    let isEdit = $(this).hasClass('editBtn');

    $('#dynamicModalTitle').text(isEdit ? 'Edit Student' : 'View Student');
    if(isEdit){
        $('#dynamicModalBody').html(`
            <form id="editForm">
                <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" class="form-control" value="${student.full_name}" required></div>
                <div class="mb-3"><label>Grade Level</label><input type="text" name="grade_level" class="form-control" value="${student.grade_level}" required></div>
                <div class="mb-3"><label>Strand</label><input type="text" name="strand" class="form-control" value="${student.strand}" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="${student.email}" required></div>
            </form>
        `);
        $('#dynamicModalFooter').html(`
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-warning" id="saveEditBtn">Save Changes</button>
        `);
    } else {
        $('#dynamicModalBody').html(`
            <p><strong>Full Name:</strong> ${student.full_name}</p>
            <p><strong>Email:</strong> ${student.email}</p>
            <p><strong>Grade Level:</strong> ${student.grade_level}</p>
            <p><strong>Strand:</strong> ${student.strand}</p>
            <p><strong>Guardian Contact:</strong> ${student.guardian_contact}</p>
            <p><strong>Status:</strong> ${student.status}</p>
        `);
        $('#dynamicModalFooter').html('<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>');
    }

    var dynamicModal = new bootstrap.Modal(document.getElementById('dynamicModal'));
    dynamicModal.show();

    $('#saveEditBtn').click(function(){
        $.post('EditStudent.php', $('#editForm').serialize() + '&id=' + student.id, function(response){
            if(response.trim() === 'success'){ location.reload(); }
            else { alert('Failed to update student.'); }
        });
    });
});
</script>

<?php include '../Includes/footer.php'; ?>
</body>
</html>
