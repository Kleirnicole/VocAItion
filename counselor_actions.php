<?php
require_once __DIR__ . '/../db/config.php';
session_start();

// Simulate logged-in counselor (replace with actual session logic)
$counselor_id = $_SESSION['user_id'] ?? 1; // fallback for demo

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $student_id = $_POST['student_id'];
  $action_type = $_POST['action_type'];
  $comments = $_POST['comments'];

  $stmt = $pdo->prepare("INSERT INTO counselor_actions (counselor_id, student_id, action_type, comments) VALUES (?, ?, ?, ?)");
  $stmt->execute([$counselor_id, $student_id, $action_type, $comments]);
  $success = true;
}

// Fetch students for dropdown
$students = $pdo->query("SELECT id, full_name FROM students ORDER BY full_name")->fetchAll(PDO::FETCH_ASSOC);

// Fetch logged actions
$stmt = $pdo->prepare("
  SELECT ca.*, s.full_name
  FROM counselor_actions ca
  JOIN students s ON ca.student_id = s.id
  WHERE ca.counselor_id = ?
  ORDER BY ca.timestamp DESC
");
$stmt->execute([$counselor_id]);
$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Counselor Actions | VocAItion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-primary">Log Counselor Action</h2>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success">Action logged successfully!</div>
    <?php endif; ?>

    <form method="POST" class="card p-4 mb-5 shadow-sm">
      <div class="mb-3">
        <label for="student_id" class="form-label">Student</label>
        <select name="student_id" class="form-select" required>
          <option value="" disabled selected>Select a student</option>
          <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['full_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="action_type" class="form-label">Action Type</label>
        <select name="action_type" class="form-select" required>
          <option value="Career Guidance">Career Guidance</option>
          <option value="Academic Counseling">Academic Counseling</option>
          <option value="Behavioral Intervention">Behavioral Intervention</option>
          <option value="Parent Meeting">Parent Meeting</option>
          <option value="Follow-Up">Follow-Up</option>
          <option value="Referral">Referral</option>
          <option value="Survey Review">Survey Review</option>
          <option value="Progress Check">Progress Check</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="comments" class="form-label">Comments</label>
        <textarea name="comments" class="form-control" rows="4" placeholder="Optional notes..."></textarea>
      </div>

      <button type="submit" class="btn btn-success">Submit Action</button>
    </form>

    <h3 class="mb-3 text-secondary">Logged Actions</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-warning">
          <tr>
            <th>Student</th>
            <th>Action Type</th>
            <th>Comments</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($actions as $action): ?>
            <tr>
              <td><?= htmlspecialchars($action['full_name']) ?></td>
              <td><?= htmlspecialchars($action['action_type']) ?></td>
              <td><?= nl2br(htmlspecialchars($action['comments'])) ?></td>
              <td><?= date('M d, Y h:i A', strtotime($action['timestamp'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>