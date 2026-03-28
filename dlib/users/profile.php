<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['email']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$current_email = $_SESSION['email'];
$message = "";

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']);

    if ($new_name === "" || $new_email === "") {
        $message = "<p class='message error'>Name and Email cannot be empty.</p>";
    } else {
        // Update name and email
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE email = ?");
        $stmt->bind_param("sss", $new_name, $new_email, $current_email);
        $success = $stmt->execute();

        // Update password if provided
        if ($new_password !== "") {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $pass_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $pass_stmt->bind_param("ss", $hashed, $new_email);
            $pass_stmt->execute();
        }

        if ($success) {
            $_SESSION['email'] = $new_email;
            $message = "<p class='message success'>Profile updated successfully!</p>";
        } else {
            $message = "<p class='message error'>Update failed. Please try again.</p>";
        }
    }
}

// Fetch user info
$stmt = $conn->prepare("SELECT name, email, role, join_date, last_logout FROM users WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/08style.css">
</head>
<body>

<div class="main-layout">
  <!-- Sidebar -->
  <div class="sidebar">
    <h1 style="font-size: 24px;">DIGITAL LIBRARY</h1>
    <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    <div class="sidebar-menu">
      <a href="view_book.php" class="menu-item">View Available Books</a>
      <a href="search_book.php" class="menu-item">Search Book</a>
      <a href="issue_request.php" class="menu-item">Issue Book</a>
      <a href="my_books.php" class="menu-item">My Issued Books</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
       <a href="history.php" class="menu-item">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item active">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="profile-box">
      <h2>👤 My Profile</h2>

      <form method="POST">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
          <label for="password">New Password</label>
          <input type="password" name="password" id="password" placeholder="Leave blank to keep current password">
        </div>

        <div class="form-group">
          <label>Role</label>
          <input type="text" value="<?= ucfirst($user['role']) ?>" disabled>
        </div>

        <div class="form-group">
          <label>Joined On</label>
          <input type="text" value="<?= date("d M Y", strtotime($user['join_date'])) ?>" disabled>
        </div>


        <div class="form-group">
          <label>Last Logout</label>
          <input type="text" value="<?= $user['last_logout'] ? date("d M Y, h:i A", strtotime($user['last_logout'])) : '-' ?>" disabled>
        </div>

        <div class="button-row">
          <button type="submit" class="btn-primary">Update Profile</button>
          <button type="reset" class="btn-secondary">Reset</button>
        </div>

        <?= $message ?>
      </form>
    </div>
  </div>
</div>

</body>
</html>