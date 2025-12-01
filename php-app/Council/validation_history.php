<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'counselor') {
    header("Location: ../login.php?error=unauthorized");
    exit();
}

require_once "../db/config.php";

try {
    $stmt = $pdo->query("
        SELECT vh.id,
               s.full_name AS student_name,
               vh.survey_id,
               vh.recommended_career,
               vh.confidence_score,
               vh.counselor_suggestion,
               vh.status,
               vh.validated_by,
               vh.created_at
        FROM validation_history vh
        JOIN students s ON vh.student_id = s.id
        ORDER BY vh.created_at DESC
    ");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Validation History</title>
    <?php include '../Includes/header.php'; ?>
    <style>
        body {
            background-color: #fdf6e3; /* light yellow background */
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #002147; /* navy blue */
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 95%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff8dc; /* pale yellow for table background */
        }
        .table th {
            background-color: #654321; /* brown header */
            color: #fdf6e3; /* light yellow text */
            padding: 10px;
            text-align: center;
        }
        .table td {
            border: 1px solid #002147; /* navy border */
            padding: 8px;
            text-align: center;
        }
        .table tr:nth-child(even) {
            background-color: #f0e68c; /* khaki yellow for alternating rows */
        }
        .table tr:hover {
            background-color: #ffe4b5; /* moccasin highlight on hover */
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
        }
        .status-validated {
            background-color: #2e8b57; /* green for validated */
        }
        .status-adjusted {
            background-color: #ff8c00; /* orange for adjusted */
        }
    </style>
</head>
<body>
<?php include '../Includes/sidebar.php'; ?>

<div class="main-content">
    <h2>Validation History</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Survey</th>
                <th>AI Recommended</th>
                <th>Confidence</th>
                <th>Counselor Suggestion</th>
                <th>Status</th>
                <th>Validated By</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['student_name'] ?? '') ?></td>
                <td><?= $r['survey_id'] ?></td>
                <td><?= htmlspecialchars($r['recommended_career'] ?? '') ?></td>
                <td><?= $r['confidence_score'] ?>%</td>
                <td><?= htmlspecialchars($r['counselor_suggestion'] ?? '') ?></td>
                <td>
                    <?php if ($r['status'] === 'validated'): ?>
                        <span class="status-badge status-validated">Validated</span>
                    <?php elseif ($r['status'] === 'adjusted'): ?>
                        <span class="status-badge status-adjusted">Adjusted</span>
                    <?php else: ?>
                        <?= htmlspecialchars($r['status'] ?? '') ?>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($r['validated_by'] ?? '') ?></td>
                <td><?= date('M d, Y h:i A', strtotime($r['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../Includes/footer.php'; ?>
</body>
</html>