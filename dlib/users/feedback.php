<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['email']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$user_email = $_SESSION['email'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['message']);

    if ($title === "" || $content === "") {
        $message = "<p class='message error'>Please fill in both fields.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_email, title, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_email, $title, $content);
        if ($stmt->execute()) {
            $message = "<p class='message success'>Feedback submitted successfully!</p>";
        } else {
            $message = "<p class='message error'>Something went wrong. Please try again.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/07style.css">
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
      <a href="feedback.php" class="menu-item active">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <form method="POST" class="feedback-form">
      <h2>📝 Submit Request or Feedback</h2>
      <p>Want the book to be returned on a specific date, or any other request, please mention it in the box below.
      <p>OR</p>
      <p>Help us make the DIGITAL LIBRARY better - write your feedback below.</p>

      <div class="form-group">
        <label for="title">Mention REQUEST or FEEDBACK</label>
        <input type="text" name="title" id="title" placeholder="REQUEST/FEEDBACK" required>
      </div>

      <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" id="message" rows="5" placeholder="Write your request or feedback here..." required></textarea>
      </div>

      <div class="button-row">
        <button type="submit" class="btn-primary">Submit</button>
        <button type="reset" class="btn-secondary">Clear</button>
      </div>

      <?= $message ?>
    </form>
  </div>
</div>

</body>
</html>