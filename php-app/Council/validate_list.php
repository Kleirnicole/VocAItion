<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    header("Location: ../login.php?error=unauthorized");
    exit();
}

require_once "../db/config.php";

try {
    $stmt = $pdo->query("
        SELECT 
            ar.id,
            ar.recommended_career,
            ar.confidence_score,
            ar.date_generated,
            sa.student_id,
            s.full_name,
            s.strand,
            s.section
        FROM ai_recommendations ar
        JOIN survey_answers sa ON ar.survey_id = sa.id
        JOIN students s ON sa.student_id = s.id
        ORDER BY ar.date_generated DESC
    ");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AI Validation List</title>
    <?php include '../Includes/header.php'; ?>
</head>
<body>
<?php include '../Includes/sidebar.php'; ?>

<div class="main-content">
    <h2>AI Results Needing Validation</h2>

    <table class="table table-bordered" style="background: #fff;">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Strand</th>
                <th>Section</th>
                <th>Recommended Course</th>
                <th>Confidence</th>
                <th>Date Generated</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['strand'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['section'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['recommended_career'] ?? '') ?></td>
                <td><?= $row['confidence_score'] ?>%</td>
                <td><?= $row['date_generated'] ?></td>
                <td>
                    <button 
                        class="btn btn-primary btn-sm validateBtn" 
                        data-id="<?= $row['id'] ?>" 
                        data-student="<?= $row['student_id'] ?>" 
                        data-career="<?= htmlspecialchars($row['recommended_career'] ?? '') ?>">
                        Validate
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Single Modal -->
<div class="modal fade" id="validateModal" tabindex="-1" aria-labelledby="validateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validate AI Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="validate_action.php" method="POST">
                    <input type="hidden" name="ai_id" id="ai_id">
                    <input type="hidden" name="student_id" id="student_id">

                    <div class="mb-3">
                        <label class="form-label">AI Recommended Career:</label>
                        <input type="text" class="form-control" id="recommended_career" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Suggested Career (Optional):</label>
                        <input type="text" name="counselor_suggestion" class="form-control" placeholder="Enter suggestion">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select name="status" class="form-select">
                            <option value="validated">Validated</option>
                            <option value="adjusted">Adjusted</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.validateBtn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('ai_id').value = this.dataset.id;
            document.getElementById('student_id').value = this.dataset.student;
            document.getElementById('recommended_career').value = this.dataset.career;

            const modal = new bootstrap.Modal(document.getElementById('validateModal'));
            modal.show();
        });
    });
</script>
<?php include '../Includes/footer.php'; ?>
</body>
</html>