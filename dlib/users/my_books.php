<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

include "../db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch books issued to this user
$sql = "SELECT 
            t.transaction_id, 
            t.book_id, 
            b.title, 
            b.author, 
            b.edition, 
            b.publisher, 
            t.issue_date, 
            t.return_date,
            t.issued_by
        FROM transactions t
        JOIN books b ON t.book_id = b.book_id
        WHERE t.user_id = '$user_id' AND t.status = 'issued'
        ORDER BY t.transaction_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Issued Books</title>
  <link rel="stylesheet" href="../css/05style.css">
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
      <a href="my_books.php" class="menu-item active">My Issued Books</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
       <a href="history.php" class="menu-item">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="table-container">
      <h2>📘 My Issued Books</h2>

      <table>
        <thead>
          <tr>
            
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Publisher</th>
            <th>Issued Date</th>
            <th>Return Date</th>
           
          </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>

            <!-- Overdue highlighting -->
            <?php 
              $today = date('Y-m-d');
              $is_overdue = ($row['return_date'] < $today);
            ?>

            <tr style="<?= $is_overdue ? 'background:#ffdddd;' : '' ?>">
              
              <td><?= $row['book_id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['author']) ?></td>
              <td><?= htmlspecialchars($row['edition']) ?></td>
              <td><?= htmlspecialchars($row['publisher']) ?></td>
              <td><?= $row['issue_date'] ?></td>
              <td><?= $row['return_date'] ?></td>
              
            </tr>
          <?php endwhile; ?>

        <?php else: ?>
          <tr><td colspan="9" style="text-align:center;">You have not issued any books.</td></tr>
        <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>

</div>
</body>
</html>
