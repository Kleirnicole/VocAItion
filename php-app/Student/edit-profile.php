<?php
session_start();
require_once __DIR__ . '/../db/config.php';

// Redirect if not logged in or not a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Fetch student profile
try {
    // Get student_id from users table
    $stmt = $pdo->prepare("SELECT student_id FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !$user['student_id']) {
        throw new Exception("Student ID not linked to user.");
    }

    $student_id = $user['student_id'];

    // If the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $grade_level = trim($_POST['grade_level']);
    $section = trim($_POST['section']);
    $strand = trim($_POST['strand']);
    $guardian_contact = trim($_POST['guardian_contact']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($email)) {
        $error = "Email is required.";
    }

    // Password mismatch check
    if (!empty($new_password) && $new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    }

    // Only run queries if no error
    if (empty($error)) {
        // Update student info
        $stmt = $pdo->prepare("
            UPDATE students 
            SET email = ?, grade_level = ?, section = ?, strand = ?, guardian_contact = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([
            $email, $grade_level, $section, $strand, $guardian_contact, $student_id
        ]);

        // Update email in users table
        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute([$email, $_SESSION['user_id']]);

        // Update password if provided
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$hashed_password, $_SESSION['user_id']]);
        }

        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit;
    }
}

    // Fetch current student data
    $stmt = $pdo->prepare("
        SELECT full_name, lrn, email, birthdate, gender, grade_level, section, strand, guardian_contact 
        FROM students WHERE id = ?
    ");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception("Student profile not found.");
    }

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile | VocAItion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body {
    background: #fdfdfb;
    padding: 40px;
    font-family: 'Segoe UI', sans-serif;
  }

  .edit-card {
    max-width: 850px;
    margin: auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 30px;
    border-left: 6px solid #FFC107;
  }

  .edit-card h3 {
    font-weight: 600;
    color: #002147;
    border-bottom: 2px solid #FFC107;
    padding-bottom: 10px;
  }

  .form-label {
    font-weight: 500;
    color: #6B4F3B;
  }

  .form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s;
  }

  .form-control:focus, .form-select:focus {
    border-color: #002147;
    box-shadow: none;
  }

  .btn-yellow {
    background-color: #FFC107;
    color: #000;
    border: none;
    font-weight: 500;
  }

  .btn-yellow:hover {
    background-color: #e0ac00;
    color: #fff;
  }

  .btn-brown {
    background-color: #6B4F3B;
    color: #fff;
    border: none;
  }

  .btn-brown:hover {
    background-color: #5a3f2f;
  }

  .input-group-text {
    background-color: #f0f0f0;
    border-radius: 0 8px 8px 0;
  }

  .alert-danger {
    background-color: #fbe9e7;
    border-left: 5px solid #d32f2f;
    color: #6B4F3B;
  }

  @media (max-width: 768px) {
    .edit-card {
      padding: 20px;
    }
  }
</style>
</head>
<body>

<div class="edit-card">
  <h3 class="text-center mb-4">Edit Profile</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">LRN</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($student['lrn']); ?>" disabled>
      </div>

      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($student['full_name']); ?>" disabled>
      </div>
      <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" disabled>
          <option value="">Select Gender</option>
          <option <?php echo ($student['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
          <option <?php echo ($student['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Birthdate</label>
        <input type="date" name="birthdate" class="form-control" value="<?php echo htmlspecialchars($student['birthdate']); ?>" disabled>
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">Grade Level</label>
        <input type="text" name="grade_level" class="form-control" value="<?php echo htmlspecialchars($student['grade_level']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">Section</label>
        <input type="text" name="section" class="form-control" value="<?php echo htmlspecialchars($student['section']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">Strand</label>
        <select name="strand" class="form-control">
          <option value="">Select Strand</option>
          <option>GAS</option>
          <option>STEM</option>
          <option>ARTS & DESIGN</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Guardian Contact</label>
        <input type="text" name="guardian_contact" class="form-control" value="<?php echo htmlspecialchars($student['guardian_contact']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">New Password</label>
        <div class="input-group">
          <input type="password" name="new_password" id="newPassword" class="form-control" placeholder="Leave blank to keep current">
          <span class="input-group-text" onclick="togglePassword('newPassword', this)" style="cursor: pointer;">
            <i class="bi bi-eye-slash"></i>
          </span>
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
          <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Re-enter new password">
          <span class="input-group-text" onclick="togglePassword('confirmPassword', this)" style="cursor: pointer;">
            <i class="bi bi-eye-slash"></i>
          </span>
        </div>
      </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-yellow px-4">💾 Save Changes</button>
      <a href="profile.php" class="btn btn-brown ms-2">↩ Cancel</a>
    </div>
  </form>
</div>
<script>
function togglePassword(fieldId, iconSpan) {
  const input = document.getElementById(fieldId);
  const icon = iconSpan.querySelector('i');

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  } else {
    input.type = "password";
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");
  }
}
</script>
</body>
</html>
