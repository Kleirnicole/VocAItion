<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guidance Counselor Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            width: 600px;
            border-radius: 15px;
            background-color: #f5e6d3;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border: 1px solid #d2b48c;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4 col-md-8 mx-auto">
        <h3 class="text-center mb-4">Guidance Counselor Registration</h3>
        <form method="POST" action="register_process.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="role" value="counselor">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" name="faculty_id" class="form-control" placeholder="Faculty ID" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="counselor_full_name" class="form-control" placeholder="Full Name (e.g., Cruz, Juan T.)" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="email" name="counselor_email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="office_location" class="form-control" placeholder="Office Location" required>
                </div>
                <div class="col-md-6 mb-3">
                    <select name="position" class="form-select" required>
                        <option value="">Select Position</option>
                        <option>Guidance Counselor</option>
                        <option>Career Advisor</option>
                        <option>Psychometrician</option>
                        <option>Guidance Designate</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning w-100 text-dark">Register</button>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-outline-dark rounded-pill px-4 py-2 shadow-sm" style="transition: all 0.3s ease;">
                        ⬅️ Back to Home
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="jsonPromptToast" class="toast text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
        <div class="d-flex">
            <div class="toast-body">
                <div style="font-family: monospace; font-size: 14px; background-color: rgba(255,255,255,0.05); padding: 8px 12px; border-radius: 6px;">
                    &nbsp;&nbsp;<span style="color:#0dcaf0;">"This Faculty ID is already registered in the system."</span><br>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] === 'pending'): ?>
<script>
    alert("Registration submitted. Please wait for admin approval. To check the approval enter your Faculty ID in your Login Portal.");
</script>
<?php endif; ?>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle icon class
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_GET['error']) && $_GET['error'] === 'faculty_exists'): ?>
<script>
    const toastEl = document.getElementById('jsonPromptToast');
    const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
    toast.show();
</script>
<?php endif; ?>
</body>
</html>