<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all transactions for this user (including returned/overdue)
$stmt = $conn->prepare("SELECT t.*, b.title 
                        FROM transactions t 
                        JOIN books b ON t.book_id = b.book_id 
                        WHERE t.user_id = ? 
                        ORDER BY t.issue_date DESC");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Book History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/010style.css">
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
      <a href="history.php" class="menu-item active">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="table-container">
      <h2>📖 My Book History</h2>
      <?php if ($result->num_rows > 0): ?>
        <table>
          <thead>
            <tr>
              <th>Book ID</th>
              <th>Title</th>
              <th>Issue Date</th>
              <th>Return Date</th>
              <th>Status</th>
             
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['book_id']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['issue_date']) ?></td>
                <td><?= htmlspecialchars($row['return_date']) ?></td>
                <td>
                  <?php
                    $status = ucfirst($row['status']);
                    $color = ($status === 'Returned') ? 'green' : (($status === 'Overdue') ? 'red' : 'orange');
                    echo "<span style='color:$color;font-weight:bold;'>$status</span>";
                  ?>
                </td>
               
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="msg">No history found. You haven’t issued any books yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>