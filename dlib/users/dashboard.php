<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email, name, last_logout FROM users WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = $user['email'];
$last_logout = $user['last_logout'] ? $user['last_logout'] : "Not Available";
$name = $user['name'];

date_default_timezone_set('Asia/Kolkata');
$today_date = date("F j, Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/02style.css">
</head>
<body>

  <!-- Top info -->
  <div class="top-info">
   
    <a href="../logout.php" class="logout-btn">Logout</a>
  </div>

  <!-- Dashboard title -->
    <h1 class="dashboard-title">DIGITAL LIBRARY</h1>
  <h1 class="dashboard-title">User Dashboard</h1>

  <!-- Features -->
  <div class="features">
    <a href="view_book.php" class="feature-box">View Available Books</a>
    <a href="search_book.php" class="feature-box">Search Book</a>
    <a href="issue_request.php" class="feature-box">Issue Book</a>
    <a href="my_books.php" class="feature-box">My Issued Books</a>
    <a href="return_request.php" class="feature-box">Return Request</a>
     <a href="history.php" class="feature-box">My History</a>
    <a href="feedback.php" class="feature-box">Request/Feedback</a>
    <a href="profile.php" class="feature-box">My Profile</a>
  </div>

</body>
</html>