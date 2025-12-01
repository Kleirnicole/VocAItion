<?php
session_start();
require_once __DIR__ . '/../db/config.php';

// Redirect if not logged in or not a counselor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'counselor') {
    header("Location: login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT counselor_id FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !$user['counselor_id']) {
        throw new Exception("Counselor ID not linked to user.");
    }

    $counselor_id = $user['counselor_id'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $office_location = trim($_POST['office_location']);
        $position = trim($_POST['position']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($full_name) || empty($email)) {
            $error = "Full name and email are required.";
        }

        if (!empty($new_password) && $new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("
                UPDATE guidance_council
                SET full_name = ?, email = ?, office_location = ?, position = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$full_name, $email, $office_location, $position, $counselor_id]);

            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->execute([$email, $_SESSION['user_id']]);

            if (!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$hashed_password, $_SESSION['user_id']]);
            }

            $_SESSION['success_message'] = "Profile updated successfully!";
            header("Location: council-profile.php");
            exit;
        }
    }

    $stmt = $pdo->prepare("
        SELECT full_name, email, office_location, position
        FROM guidance_council
        WHERE id = ?
    ");
    $stmt->execute([$counselor_id]);
    $counselor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$counselor) {
        throw new Exception("Counselor profile not found.");
    }

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Counselor Profile | VocAItion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #fdf6e3; /* soft beige background */
      padding: 40px;
      font-family: 'Segoe UI', sans-serif;
    }
    .edit-card {
      max-width: 800px;
      margin: auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 30px;
      border-top: 6px solid #ffc107; /* yellow accent */
    }
    .edit-card h3 {
      font-weight: 600;
      color: #1d3557; /* navy blue */
    }
    .form-label {
      font-weight: 500;
      color: #8B5E3C; /* brown */
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
    }
    .btn-save {
      background-color: #1d3557; /* navy */
      color: #fff;
      border: none;
    }
    .btn-save:hover {
      background-color: #27496d;
    }
    .btn-cancel {
      background-color: #8B5E3C; /* brown */
      color: #fff;
      border: none;
    }
    .btn-cancel:hover {
      background-color: #6f442a;
    }
    .input-group-text {
      background: #ffc107; /* yellow */
      border: none;
      cursor: pointer;
    }
    .alert-danger {
      background-color: #e63946;
      color: #fff;
      border: none;
    }
  </style>
</head>
<body>

<div class="edit-card">
  <h3 class="text-center mb-4">Edit Counselor Profile</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($counselor['full_name']); ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($counselor['email']); ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Office Location</label>
        <input type="text" name="office_location" class="form-control" value="<?php echo htmlspecialchars($counselor['office_location']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">Position</label>
        <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($counselor['position']); ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">New Password</label>
        <div class="input-group">
          <input type="password" name="new_password" id="newPassword" class="form-control" placeholder="Leave blank to keep current">
          <span class="input-group-text" onclick="togglePassword('newPassword', this)">
            <i class="bi bi-eye-slash"></i>
          </span>
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
          <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Re-enter new password">
          <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
            <i class="bi bi-eye-slash"></i>
          </span>
        </div>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-save px-4">Save Changes</button>
        <a href="Council-profile.php" class="btn btn-cancel ms-2">Cancel</a>
      </div>
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