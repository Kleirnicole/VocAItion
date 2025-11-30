<?php
session_start();
require 'db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = md5($_POST['password']); // hash input password using md5

    try {
        $stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ? AND role = 'admin' LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['password']) {
            // password matched
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['role'] = $admin['role'];

            header("Location: Admin/admin-dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
  background: linear-gradient(to right, #002147, #ffc107); /* Navy blue to yellow */
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Segoe UI', sans-serif;
}

.card {
  width: 380px;
  border-radius: 15px;
  background-color: #f5e6d3; /* Light brown tone */
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  border: 1px solid #d2b48c;
}

.card h3 {
  color: #002147; /* Navy blue */
  font-weight: 600;
}

.form-label {
  color: #5c4432; /* Rich brown for labels */
  font-weight: 500;
}

.input-group-text {
  background-color: #f5e6d3;
  border: 1px solid #ced4da;
  color: #5c4432;
}

.btn-warning {
  background-color: #ffc107;
  border: none;
  font-weight: 600;
}

.btn-outline-dark {
  border-color: #002147;
  color: #002147;
}

.btn-outline-dark:hover {
  background-color: #002147;
  color: #fff;
}
</style>
</head>
<body>

<div class="card p-4">
  <h3 class="text-center mb-3">Admin Login</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" class="form-control" required>
        <span class="input-group-text" onclick="togglePassword('loginPassword', this)" style="cursor: pointer;">
          <i class="bi bi-eye-slash"></i>
        </span>
      </div>
    </div>

    <button type="submit" class="btn btn-warning w-100 text-dark">Login</button>
  </form>

  <div class="text-center mt-3">
    <a href="index.php" class="btn btn-outline-dark rounded-pill px-4 py-2 shadow-sm" style="transition: all 0.3s ease;">
      ⬅️ Back to Home
    </a>
  </div>
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
