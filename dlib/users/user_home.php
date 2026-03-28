<?php
session_start();
include('../db_connect.php');

// Check login & role
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email, last_logout, name FROM users WHERE user_id=?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = $user['email'];
$last_logout = $user['last_logout'] ? $user['last_logout'] : "Not Available";
$name = $user['name'];

// ✨ FIX: Update session name to ensure welcome message always shows correct user
$_SESSION['name'] = $name;

date_default_timezone_set('Asia/Kolkata');
$today_date = date("F j, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/01style.css">
</head>
<body>

  <!-- Top info -->
  <div class="top-info">
    <span>Email: <?= htmlspecialchars($email) ?></span>
    <span>Last Logout: <?= htmlspecialchars($last_logout) ?></span>
    <span>Today's Date: <?= htmlspecialchars($today_date) ?></span>
    <a href="../logout.php" class="logout-btn">Logout</a>
  </div>

  <!-- Welcome box -->
  <div class="welcome-container">
    <h1>Welcome to DIGITAL LIBRARY <?= htmlspecialchars($_SESSION['name']) ?> 👋</h1>
    <p>Click on <strong>Go to Dashboard</strong> to explore your library features</p>
    <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
  </div>

</body>
</html>
