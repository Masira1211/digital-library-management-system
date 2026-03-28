<?php
session_start();
include('../db_connect.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
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

$today_date = date("F j, Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Home</title>
<link rel="stylesheet" href="../css/3style.css">
</head>
<body>
    <!-- Top info (no container) -->
    <div class="top-info">
        <span>Email: <?php echo htmlspecialchars($email); ?></span>
        <span>Last Logout: <?php echo $last_logout; ?></span>
        <span>Today's Date: <?php echo $today_date; ?></span>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Welcome container (centered box) -->
    <div class="welcome-container">
        <h1>Welcome <?php echo htmlspecialchars($name); ?></h1>
        <p>Click on <strong>Go to Dashboard</strong> to access the features</p>
        <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
    </div>
</body>
</html>
