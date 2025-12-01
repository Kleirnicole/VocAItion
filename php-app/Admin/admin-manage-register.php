<?php
session_start();
require_once "../db/config.php";

// --- Security check (admin only)
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

// --- Handle approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = (int) $_POST['id'];
    $action = $_POST['action'];

    // Fetch the pending record
    $stmt = $pdo->prepare("SELECT * FROM pending_registrations WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        if ($action === 'approve') {
            try {
                $pdo->beginTransaction();

                // Hash password if not already hashed
                $password = $record['password'];
                if (!preg_match('/^\$2y\$/', $password)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                }

                // === STUDENT APPROVAL ===
                if ($record['role'] === 'student') {
                    // Skip if LRN already exists
                    $checkStudent = $pdo->prepare("SELECT COUNT(*) FROM students WHERE lrn = ?");
                    $checkStudent->execute([$record['lrn']]);
                    if ($checkStudent->fetchColumn() == 0) {
                        $insertStudent = $pdo->prepare("
                            INSERT INTO students 
                            (lrn, full_name, email, password, birthdate, gender, grade_level, section, guardian_contact, strand, created_at, status, profile_image)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active', 'default.png')
                        ");
                        $insertStudent->execute([
                            $record['lrn'],
                            $record['full_name'],
                            $record['email'],
                            $password,
                            $record['birthdate'],
                            $record['gender'],
                            $record['grade_level'],
                            $record['section'],
                            $record['guardian_contact'],
                            $record['strand'],
                            $record['created_at']
                        ]);
                        $student_id = $pdo->lastInsertId();

                        // Add to users if not existing
                        if (!empty($record['email'])) {
                            $checkUser = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                            $checkUser->execute([$record['email']]);
                            if ($checkUser->fetchColumn() == 0) {
                                $pdo->prepare("
                                    INSERT INTO users (email, password, role, student_id)
                                    VALUES (?, ?, 'student', ?)
                                ")->execute([$record['email'], $password, $student_id]);
                            }
                        }
                    }
                }

                // === COUNSELOR APPROVAL ===
                elseif ($record['role'] === 'counselor') {
                    // Skip if faculty_id already exists
                    $checkCounselor = $pdo->prepare("SELECT COUNT(*) FROM guidance_council WHERE faculty_id = ?");
                    $checkCounselor->execute([$record['faculty_id']]);
                    if ($checkCounselor->fetchColumn() == 0) {
                        $insertCounselor = $pdo->prepare("
                            INSERT INTO guidance_council 
                            (faculty_id, full_name, email, password, office_location, position, created_at, status, profile_image)
                            VALUES (?, ?, ?, ?, ?, ?, ?, 'Active', 'default.png')
                        ");
                        $insertCounselor->execute([
                            $record['faculty_id'],
                            $record['full_name'],
                            $record['email'],
                            $password,
                            $record['office_location'],
                            $record['position'],
                            $record['created_at']
                        ]);

                        $counselor_id = $pdo->lastInsertId();

                        // Add to users if not existing
                        if (!empty($record['email'])) {
                            $checkUser = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                            $checkUser->execute([$record['email']]);
                            if ($checkUser->fetchColumn() == 0) {
                                $pdo->prepare("
                                    INSERT INTO users (email, password, role, counselor_id)
                                    VALUES (?, ?, 'counselor', ?)
                                ")->execute([$record['email'], $password, $counselor_id]);
                            }
                        }
                    }
                }

                // Remove from pending registrations
                $pdo->prepare("DELETE FROM pending_registrations WHERE id = ?")->execute([$id]);

                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollBack();
                die("Approval failed: " . $e->getMessage());
            }

        } elseif ($action === 'reject') {
            $pdo->prepare("DELETE FROM pending_registrations WHERE id = ?")->execute([$id]);
        }
    }

    header("Location: admin-manage-register.php");
    exit();
}

// --- Fetch all pending registrations
$stmt = $pdo->query("SELECT * FROM pending_registrations ORDER BY created_at DESC");
$pending = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Registrations | VocAItion</title>
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
<body class="bg-light">
    <?php include '../Includes/admin-sidebar.php';?>
    <div class="container mt-5">
        <h3 class="mb-4 text-center">Pending Registration Approvals</h3>

        <?php if (empty($pending)): ?>
            <div class="alert alert-info text-center">No pending registrations found.</div>
        <?php else: ?>
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>LRN / Faculty ID</th>
                        <th>Strand / Position</th>
                        <th>Date Registered</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($pending as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= ucfirst($row['role']); ?></td>
                            <td><?= htmlspecialchars($row['full_name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?= $row['role'] === 'student' ? htmlspecialchars($row['lrn']) : htmlspecialchars($row['faculty_id']); ?>
                            </td>
                            <td>
                                <?= $row['role'] === 'student' ? htmlspecialchars($row['strand']) : htmlspecialchars($row['position']); ?>
                            </td>
                            <td><?= date('Y-m-d', strtotime($row['created_at'])); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
