<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

// Search logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_sql = $search ? "WHERE user_email LIKE '%$search%' OR title LIKE '%$search%'" : "";

$query = "SELECT * FROM feedback $search_sql ORDER BY submitted_on DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Feedback</title>
  <link rel="stylesheet" href="../css/13style.css">
</head>
<body>

<div class="main-layout">

  <!-- Sidebar -->
  <div class="sidebar">
    <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    <div class="sidebar-menu">
      <a href="add_book.php" class="menu-item">Add Book</a>
      <a href="view_book.php" class="menu-item">View Book</a>
      <a href="search_book.php" class="menu-item">Search Book</a>
      <a href="modify_book.php" class="menu-item">Modify Book</a>
      <a href="delete_book.php" class="menu-item">Delete Book</a>
      <a href="issue_book.php" class="menu-item">Issue Book</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
      <a href="manage_books.php" class="menu-item">Manage Books</a>
      <a href="view_feedback.php" class="menu-item active">View Request/Feedback</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="feedback-container">
      <h2>User Request or Feedback</h2>

      <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by email or title" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
      </form>

      <table>
        <thead>
          <tr>
           
            <th>User Email</th>
            <th>Request/Feedback</th>
            <th>Message</th>
            <th>Submitted On</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
             
              <td><?php echo htmlspecialchars($row['user_email']); ?></td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
              <td><?php echo $row['submitted_on']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center;">No feedback found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</body>
</html>