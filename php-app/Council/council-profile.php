<?php
session_start();
require_once __DIR__ . '/../db/config.php';

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

    $stmt = $pdo->prepare("
        SELECT full_name, email, office_location, position, profile_image
        FROM guidance_council
        WHERE id = ?
    ");
    $stmt->execute([$user['counselor_id']]);
    $counselor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$counselor) {
        throw new Exception("Counselor profile not found.");
    }

    $profileImage = !empty($counselor['profile_image'])
        ? '../img/profile_pictures/' . $counselor['profile_image']
        : '../img/profile_pictures/defaultprofile.webp';

} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

    if (in_array($file['type'], $allowedTypes) && $file['size'] <= 2 * 1024 * 1024) {
        $filename = uniqid() . '_' . basename($file['name']);
        $target = '../img/profile_pictures/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $stmt = $pdo->prepare("UPDATE guidance_council SET profile_image = ? WHERE id = ?");
            $stmt->execute([$filename, $user['counselor_id']]);
            $_SESSION['success_message'] = "Profile picture updated!";
        } else {
            $_SESSION['success_message'] = "Upload failed.";
        }
    } else {
        $_SESSION['success_message'] = "Invalid file type or size.";
    }

    header("Location: council-profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Counselor Profile | VocAItion</title>
  <?php include '../Includes/header.php'; ?>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .profile-img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #ffc107;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .card-title {
      color: #b08968;
    }
    .btn-warning {
      background-color: #ffc107;
      color: #1d3557;
      font-weight: 600;
      border: none;
    }
    .btn-warning:hover {
      background-color: #e0a800;
    }
    .alert-success {
      background-color: #ffc107;
      color: #1d3557;
      font-weight: 500;
    }
    .alert-danger {
      background-color: #e63946;
      color: #fff;
    }
  </style>
</head>
<body>
  <?php include '../Includes/sidebar.php'; ?>

  <main class="main-content container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if (!empty($_SESSION['success_message'])): ?>
          <div class="alert alert-success text-center">
            <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php else: ?>
          <div class="card shadow-lg border-0">
            <div class="card-body text-center">
              <h3 class="card-title fw-bold mb-4">Counselor Profile</h3>

              <form action="council-profile.php" method="POST" enctype="multipart/form-data" class="d-inline-block position-relative">
                <input type="file" name="profile_image" id="profileInput" accept="image/*" style="display: none;" onchange="this.form.submit()">
                <label for="profileInput" style="cursor: pointer;">
                  <img src="<?= $profileImage ?>" alt="Profile Picture" class="profile-img mb-2"
     onerror="this.onerror=null;this.src='../img/defaultprofile.webp';">
                  <div class="position-absolute top-50 start-50 translate-middle text-white fw-semibold"
                       style="background-color: rgba(0,0,0,0.4); padding: 4px 10px; border-radius: 6px; font-size: 0.9rem;">
                    Upload
                  </div>
                </label>
              </form>

              <div class="row row-cols-2 g-3 mt-4 text-start">
  <div class="col">
    <div class="bg-light p-3 rounded shadow-sm">
      <strong>Name:</strong><br>
      <?= htmlspecialchars($counselor['full_name']) ?>
    </div>
  </div>
  <div class="col">
    <div class="bg-light p-3 rounded shadow-sm">
      <strong>Email:</strong><br>
      <?= htmlspecialchars($counselor['email']) ?>
    </div>
  </div>
  <div class="col">
    <div class="bg-light p-3 rounded shadow-sm">
      <strong>Position:</strong><br>
      <?= htmlspecialchars($counselor['position']) ?>
    </div>
  </div>
  <div class="col">
    <div class="bg-light p-3 rounded shadow-sm">
      <strong>Office:</strong><br>
      <?= htmlspecialchars($counselor['office_location']) ?>
    </div>
  </div>
</div>

              <div class="mt-4">
                <a href="edit-counselor-profile.php" class="btn btn-warning">📝 Edit Details</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php include '../Includes/footer.php'; ?>
</body>
</html>