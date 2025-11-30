
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Login | VocAItion</title>
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
  <h3 class="text-center mb-3">Student Login</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <input type="hidden" name="role" value="student">

    <div class="mb-3">
      <label class="form-label">Enter LRN</label>
      <input type="text" name="identifier" class="form-control" required>
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
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="lrnStatusToast" class="toast text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
    <div class="d-flex">
      <div class="toast-body" id="lrnStatusMessage">
        <!-- Message will be injected here -->
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelector('input[name="identifier"]').addEventListener('blur', function () {
  const lrn = this.value.trim();
  if (!lrn) return;

  fetch('check_lrn.php?lrn=' + encodeURIComponent(lrn))
    .then(response => response.json())
    .then(data => {
      const toastEl = document.getElementById('lrnStatusToast');
      const toastBody = document.getElementById('lrnStatusMessage');

      const message = data.exists
        ? `"✅ Registered. Please enter your password." `
        : `"⏳ Waiting for admin approval or please register first." `;

      toastBody.innerHTML = `
        <div class="bg-opacity-25 p-3 rounded text-start" style="font-family: monospace; font-size: 14px;">
          &nbsp;&nbsp;<span class="text-info">message</span>: 
          <span class="${data.exists ? 'text-success' : 'text-danger'}">
            ${data.exists 
              ? '"✅ Registered. Please enter your password."' 
              : '"⏳ Waiting for admin approval or please register first."'}
          </span>
        </div>
      `;

      const toast = new bootstrap.Toast(toastEl, { delay: 5500 });
      toast.show();
    });
});
</script>

</body>
</html>
