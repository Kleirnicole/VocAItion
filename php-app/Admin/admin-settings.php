<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Settings | VocAItion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
    --primary: #2563EB;
    --secondary: #10B981;
    --bg-light: #F9FAFB;
    --card-bg: #ffffff;
    --muted: #6B7280;
    --shadow: rgba(0,0,0,0.1);
}
body { background: var(--bg-light); font-family:'Inter',sans-serif; margin:0; padding:0; }
.container { max-width: 1200px; margin:2rem auto; }
h3 { color: var(--primary); margin-bottom:1.5rem; font-weight:600; }

.card { border:none; border-radius:12px; box-shadow:0 4px 12px var(--shadow); transition: transform 0.2s; }
.card:hover { transform: translateY(-3px); }
.card-header { font-weight:600; font-size:1.1rem; }
.card-body { padding:1rem 1.5rem; }
.stat-value { font-size:1.6rem; font-weight:700; margin-top:0.3rem; }
.small-muted { color: var(--muted); font-size:0.9rem; }

.chart-card { padding:1.5rem; }

.table-responsive { overflow-x:auto; }
.table th, .table td { vertical-align: middle; }

@media (max-width:768px){
    .stat-value { font-size:1.3rem; }
    .card-header { font-size:1rem; }
    .table th, .table td { font-size:0.85rem; }
}
.sidebar { position:fixed; top:0; left:0; width:230px; height:100vh; background: var(--card-bg); border-right:1px solid #e5e7eb; overflow-y:auto; }
.main { margin-left:230px; height:100vh; display:flex; flex-direction:column; }
.topbar { background: var(--card-bg); height:64px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; padding:0 1rem; position:sticky; top:0; z-index:10; }
.content { flex:1; overflow-y:auto; padding:1.5rem; }
.card { border-radius:10px; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
.small-muted { color: var(--muted); font-size:0.9rem; }
.table-responsive { overflow-x:auto; }
.table th, .table td { vertical-align: middle; }
.sidebar .nav-link { color:#111827; }
.sidebar .nav-link.active { background: rgba(37,99,235,0.1); color: var(--brand); border-radius:6px; }
</style>
</head>
<body>

<?php include '../Includes/admin-sidebar.php';?>

<main class="main">
  <!-- Topbar -->
  <div class="topbar">
    <h5 class="mb-0">Admin Settings</h5>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary btn-sm">🔔</button>
      <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Admin</button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="db/logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Account Settings -->
    <div class="card p-4">
      <h5 class="section-title">Account Settings</h5>
      <form>
        <div class="mb-3">
          <label for="adminName" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="adminName" placeholder="Admin Name">
        </div>
        <div class="mb-3">
          <label for="adminEmail" class="form-label">Email</label>
          <input type="email" class="form-control" id="adminEmail" placeholder="admin@example.com">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
      </form>
    </div>

    <!-- Change Password -->
    <div class="card p-4">
      <h5 class="section-title">Change Password</h5>
      <form>
        <div class="mb-3">
          <label for="currentPass" class="form-label">Current Password</label>
          <input type="password" class="form-control" id="currentPass">
        </div>
        <div class="mb-3">
          <label for="newPass" class="form-label">New Password</label>
          <input type="password" class="form-control" id="newPass">
        </div>
        <div class="mb-3">
          <label for="confirmPass" class="form-label">Confirm New Password</label>
          <input type="password" class="form-control" id="confirmPass">
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
      </form>
    </div>

    <!-- Notifications -->
    <div class="card p-4">
      <h5 class="section-title">Notifications</h5>
      <form>
        <div class="form-check form-switch mb-2">
          <input class="form-check-input" type="checkbox" id="emailNotif" checked>
          <label class="form-check-label" for="emailNotif">Email Notifications</label>
        </div>
        <div class="form-check form-switch mb-2">
          <input class="form-check-input" type="checkbox" id="pushNotif">
          <label class="form-check-label" for="pushNotif">Push Notifications</label>
        </div>
      </form>
    </div>

    <!-- Theme -->
    <div class="card p-4">
      <h5 class="section-title">Theme</h5>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="darkMode">
        <label class="form-check-label" for="darkMode">Enable Dark Mode</label>
      </div>
    </div>

  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const darkModeToggle = document.getElementById('darkMode');
darkModeToggle.addEventListener('change', () => {
    if(darkModeToggle.checked) {
        document.body.style.background = '#1f2937';
        document.body.style.color = '#f3f4f6';
    } else {
        document.body.style.background = '#f3f4f6';
        document.body.style.color = '#111827';
    }
});
</script>

</body>
</html>
