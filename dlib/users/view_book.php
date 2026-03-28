<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

// Fetch only available books
$result = $conn->query("SELECT * FROM books WHERE available_copies > 0 ORDER BY book_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Books</title>
  <link rel="stylesheet" href="../css/09style.css">
</head>
<body>
<div class="main-layout">

  <!-- Sidebar -->
  <div class="sidebar">
  <h1 style="font-size: 24px;">DIGITAL LIBRARY</h1>
    <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    <div class="sidebar-menu">
      <a href="view_book.php" class="menu-item active">View Available Books</a>
      <a href="search_book.php" class="menu-item">Search Book</a>
      <a href="issue_request.php" class="menu-item">Issue Book</a>
      <a href="my_books.php" class="menu-item">My Issued Books</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
       <a href="history.php" class="menu-item">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="table-container">
      <h2>📚 Available Books</h2>
      <table>
        <thead>
          <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Publisher</th>
            <th>Published Date</th>
            <th>Branch</th>
            <th>Available Copies</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['book_id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['author']) ?></td>
              <td><?= $row['edition'] ?></td>
              <td><?= htmlspecialchars($row['publisher']) ?></td>
              <td><?= $row['published_date'] ?></td>
              <td><?= $row['branch'] ?></td>
              <td><?= $row['available_copies'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">No books currently available.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</body>
</html>