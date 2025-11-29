<?php
session_start();
require_once "../db/config.php";

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

try {
    $query = "SELECT id, realistic, investigative, artistic, social, enterprising, conventional, top_3_types, created_at FROM riasec_scores ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $assessments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching assessments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assessments | VocAItion</title>
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
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>🧾 Career Assessments</h4>
    </div>

    <?php if (!empty($assessments)): ?>
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Realistic</th>
                    <th>Investigative</th>
                    <th>Artistic</th>
                    <th>Social</th>
                    <th>Enterprising</th>
                    <th>Conventional</th>
                    <th>Top 3 Types</th>
                    <th>Date Taken</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($assessments as $i => $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['realistic']) ?></td>
                    <td><?= htmlspecialchars($a['investigative']) ?></td>
                    <td><?= htmlspecialchars($a['artistic']) ?></td>
                    <td><?= htmlspecialchars($a['social']) ?></td>
                    <td><?= htmlspecialchars($a['enterprising']) ?></td>
                    <td><?= htmlspecialchars($a['conventional']) ?></td>
                    <td><?= htmlspecialchars($a['top_3_types']) ?></td>
                    <td><?= date('M d, Y', strtotime($a['created_at'])) ?></td>
                    <td>
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $a['id'] ?>">View</button>

                        <!-- Modal -->
                        <div class="modal fade" id="modal<?= $a['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $a['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?= $a['id'] ?>">Assessment Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Realistic:</strong> <?= $a['realistic'] ?></li>
                                    <li class="list-group-item"><strong>Investigative:</strong> <?= $a['investigative'] ?></li>
                                    <li class="list-group-item"><strong>Artistic:</strong> <?= $a['artistic'] ?></li>
                                    <li class="list-group-item"><strong>Social:</strong> <?= $a['social'] ?></li>
                                    <li class="list-group-item"><strong>Enterprising:</strong> <?= $a['enterprising'] ?></li>
                                    <li class="list-group-item"><strong>Conventional:</strong> <?= $a['conventional'] ?></li>
                                    <li class="list-group-item"><strong>Top 3 Types:</strong> <?= $a['top_3_types'] ?></li>
                                    <li class="list-group-item"><strong>Date Taken:</strong> <?= date('M d, Y', strtotime($a['created_at'])) ?></li>
                                </ul>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">No RIASEC assessments found yet.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
