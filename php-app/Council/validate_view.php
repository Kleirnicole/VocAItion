<?php
require_once "../db/config.php";

$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT * FROM ai_recommendations WHERE id = ?
");
$stmt->execute([$id]);
$data = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate AI Result</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4 text-center">Validate AI Result</h3>

                    <form action="validate_action.php" method="POST">
                        <input type="hidden" name="ai_id" value="<?= $data['id'] ?>">
                        <input type="hidden" name="student_id" value="<?= $data['student_id'] ?>">
                        <input type="hidden" name="survey_id" value="<?= $data['survey_id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">AI Recommended Career:</label>
                            <input type="text" class="form-control" value="<?= $data['recommended_career'] ?>" readonly>
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
</div>

<!-- Bootstrap JS CDN (Optional for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
