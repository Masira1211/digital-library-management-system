<?php
session_start();
include('../db_connect.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch admin details
$stmt = $conn->prepare("SELECT email, name, last_logout FROM users WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = $user['email'];
$last_logout = $user['last_logout'] ? $user['last_logout'] : "Not Available";
$today_date = date("F j, Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/4style.css">
</head>
<body>
    <!-- Top info -->
    <div class="top-info">
        
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Dashboard title -->
    <h1 class="dashboard-title">Admin Dashboard</h1>

    <!-- Features -->
    <div class="features">
        <a href="add_book.php" class="feature-box">Add Book</a>
        <a href="view_book.php" class="feature-box">View Book</a>
        <a href="search_book.php" class="feature-box">Search Book</a>

        <a href="modify_book.php" class="feature-box">Modify Book</a>
        <a href="delete_book.php" class="feature-box">Delete Book</a>
        <a href="issue_book.php" class="feature-box">Issue Book</a>

        <a href="return_request.php" class="feature-box">Return Request</a>
        <a href="manage_books.php" class="feature-box">Manage Books</a>
        <a href="view_feedback.php" class="feature-box">View Request/Feedback</a>
    </div>
</body>
</html>
