<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Database connection
require_once __DIR__ . '/db/config.php';

// Confirm connection
if ($conn && !$conn->connect_error) {
    echo "Connected to database successfully (MySQLi)!";
} else {
    die("Database connection failed.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>VocAItion Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      background: linear-gradient(135deg, #002147, #ffc107);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Poppins", sans-serif;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      padding: 40px 30px;
      background: #f5e6d3;
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid #d2b48c;
    }
    h1 {
      font-size: 1.6rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #002147;
    }
    h5 {
      font-size: 1.3rem;
      font-weight: 500;
      color: #002147;
    }
    .btn {
      width: 100%;
      margin: 10px 0;
      padding: 12px;
      font-size: 1rem;
      font-weight: 500;
      border-radius: 30px;
      background-color: #8B5E3C;
      color: #fff;
      transition: all 0.3s ease;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    footer {
      text-align: center;
      margin-top: 20px;
      font-size: 0.85rem;
      color: #555;
    }
    @media (max-width: 576px) {
      h1 { font-size: 1.2rem; }
      .card img { width: 100px; }
      h5 { font-size: 1rem; }
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Sagay National High School</h1>

    <div class="d-flex flex-column align-items-center justify-content-center mb-3">
      <a href="https://sagaynhs.edu.ph" target="_blank">
        <img src="sagayNHS_logo.png" alt="Sagay NHS Logo"
             style="width: 120px; height: auto; max-width: 100%; margin-bottom: 10px;"
             onerror="this.style.display='none';">
      </a>
      <h5>VocAItion: AI-Powered Career Path Suggestion Tool</h5>
    </div>

    <p class="text-muted mb-4">Select your portal below</p>

    <form action="admin-login.php" method="get">
      <button type="submit" class="btn">Principal</button>
    </form>

    <form action="counselor-login.php" method="get">
      <button type="submit" class="btn">Guidance Counselor</button>
    </form>

    <form action="student-login.php" method="get">
      <button type="submit" class="btn">Student</button>
    </form>

    <form action="register.php" method="get">
      <button type="submit" class="btn">Register (Guidance)</button>
    </form>

    <footer>
      &copy; <?= date("Y"); ?> VocAItion Application. All rights reserved.
    </footer>
  </div>
</body>
</html>