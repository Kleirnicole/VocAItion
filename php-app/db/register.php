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
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4 col-md-8 mx-auto">
        <h3 class="text-center mb-4">User Registration</h3>
        <form method="POST" action="register_process.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="counselor">Counselor</option>
                </select>
            </div>

            <div id="studentFields" style="display:none;">
                <h5 class="mt-3">Student Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3"><input type="text" name="lrn" class="form-control" placeholder="LRN"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="full_name" class="form-control" placeholder="Full Name"></div>
                    <div class="col-md-6 mb-3"><input type="email" name="email" class="form-control" placeholder="Email"></div>
                    <div class="col-md-6 mb-3"><input type="date" name="birthdate" class="form-control"></div>
                    <div class="col-md-6 mb-3">
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3"><input type="text" name="grade_level" class="form-control" placeholder="Grade Level"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="section" class="form-control" placeholder="Section"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="strand" class="form-control" placeholder="Strand"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="guardian_contact" class="form-control" placeholder="Guardian Contact"></div>
                </div>
            </div>

            <div id="counselorFields" style="display:none;">
                <h5 class="mt-3">Counselor Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3"><input type="text" name="faculty_id" class="form-control" placeholder="Faculty ID"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="full_name" class="form-control" placeholder="Full Name"></div>
                    <div class="col-md-6 mb-3"><input type="email" name="email" class="form-control" placeholder="Email"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="office_location" class="form-control" placeholder="Office Location"></div>
                    <div class="col-md-6 mb-3"><input type="text" name="position" class="form-control" placeholder="Position"></div>
                </div>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Register</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    document.getElementById('studentFields').style.display = this.value === 'student' ? 'block' : 'none';
    document.getElementById('counselorFields').style.display = this.value === 'counselor' ? 'block' : 'none';
});
</script>
</body>
</html>
