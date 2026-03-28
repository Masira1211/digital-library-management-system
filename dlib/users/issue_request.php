<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = trim($_POST['book_id']);

    if ($book_id === "") {
        $message = "<p class='message error'>Please enter a Book ID.</p>";
    } else {
        $stmt = $conn->prepare("SELECT available_copies FROM books WHERE book_id = ?");
        $stmt->bind_param("s", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = "<p class='message error'>Book ID not found.</p>";
        } else {
            $book = $result->fetch_assoc();
            if ($book['available_copies'] <= 0) {
                $message = "<p class='message error'>This book is currently not available.</p>";
            } else {
                // Check if user already issued same book
                $check = $conn->prepare("SELECT * FROM transactions 
                                         WHERE user_id = ? AND book_id = ? 
                                         AND status IN ('issued', 'overdue')");
                $check->bind_param("ss", $user_id, $book_id);
                $check->execute();
                $check_result = $check->get_result();

                if ($check_result->num_rows > 0) {
                    $message = "<p class='message error'>You already have this book issued or overdue.</p>";
                } else {
                    // Issue book
                    $issue_date = date('Y-m-d');
                    $return_date = date('Y-m-d', strtotime('+14 days')); // Auto 14 days for users

                    $insert = $conn->prepare("INSERT INTO transactions 
                        (user_id, book_id, issue_date, return_date, status, issued_by)
                        VALUES (?, ?, ?, ?, 'issued', 'user')");

                    $insert->bind_param("ssss", $user_id, $book_id, $issue_date, $return_date);

                    if ($insert->execute()) {
                        // Reduce available copies
                        $update = $conn->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE book_id = ?");
                        $update->bind_param("s", $book_id);
                        $update->execute();

                        $message = "<p class='message success'>Book issued successfully! Return before: <strong>$return_date</strong></p>";
                    } else {
                        $message = "<p class='message error'>Something went wrong. Please try again.</p>";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request Book Issue</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/04style.css">
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
      <a href="issue_request.php" class="menu-item active">Issue Book</a>
      <a href="my_books.php" class="menu-item">My Issued Books</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
       <a href="history.php" class="menu-item">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <form method="POST" class="issue-form">
      <h2>📚 Issue Book</h2>
      <p>Enter the Book ID you wish to issue. Only available books can be issued.</p>

      <div class="form-group">
        <label for="book_id">Book ID</label>
        <input type="text" name="book_id" id="book_id" placeholder="Enter Book ID" required>
      </div>

      <div class="button-row">
        <button type="submit" class="btn-primary">Issue Book</button>
        <button type="reset" class="btn-secondary">Clear</button>
      </div>

      <?= $message ?>
    </form>

</div>
</body>
</html>
