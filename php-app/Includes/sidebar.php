<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? null;
?>
<!-- Toggle Button -->
<span id="sidebarToggle" class="toggle-btn">☰</span>

<!-- Sidebar -->
<div id="sidebar" class="sidebar d-flex flex-column justify-content-between vh-100 p-3 bg-light">
  <div>
    <h2 class="sidebar-title">VocAItion</h2>
    <nav class="sidebar-links">
      <?php if ($role === 'student'): ?>
        <a href="../Student/Student-dashboard.php">
          <i class="bi bi-house-fill text-white me-2"></i> <span>Dashboard</span>
        </a>
        <a href="../Student/StudentSurvey.php">
          <i class="bi bi-journal-text text-white me-2"></i> <span>RIASEC Survey</span>
        </a>
        <a href="../Student/Studentai-suggestions.php">
          <i class="bi bi-robot text-white me-2"></i> <span>AI Suggestions</span>
        </a>
        <a href="../Student/StudentCareerpath.php">
          <i class="bi bi-mortarboard-fill text-white me-2"></i> <span>Suggested Schools</span>
        </a>
        <a href="../Student/Profile.php">
          <i class="bi bi-person-fill text-white me-2"></i> <span>Profile</span>
        </a>
      <?php elseif ($role === 'counselor'): ?>
        
        <a href="Counselor-Dashboard.php"><i class="bi bi-house-door me-2"></i>Dashboard</a>
        <a href="CouselorSurveyResults.php"><i class="bi bi-clipboard-data me-2"></i>Survey Results</a>
        <a href="CareerReportCouncil.php"><i class="bi bi-bar-chart-line me-2"></i>Career Reports</a>
        <a href="GraduateReportCouncil.php" class="active"><i class="bi bi-mortarboard me-2"></i>Graduate Report</a>
        <a href="CounselorManageStudents.php"><i class="bi bi-people me-2"></i>Manage Students</a>
        <a href="../Council/council-profile.php"><i class="bi bi-person-circle me-2"></i>Profile</a>
      <?php endif; ?>
    </nav>

    <!-- Logout Button -->
    <div class="mt-4 text-center">
      <button class="btn w-100 text-white fw-semibold py-3" style="
        background-color: transparent;
        box-shadow: 0 0 10px rgba(255, 193, 7, 0.6);
        border: 2px solid #ffc107;
        font-size: 1rem;
        border-radius: 8px;
      " data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </button>
    </div>
  </div>

  <div class="small text-warning text-center sidebar-footer">
    <div>© 2025 VocAItion.</div>
    <div>All rights reserved.</div>
  </div>
</div>