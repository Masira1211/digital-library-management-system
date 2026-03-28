<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginnout/login.php");
    exit();
}

// Approve return
if (isset($_GET['approve'])) {
    $request_id = intval($_GET['approve']);

    $res = $conn->query("SELECT * FROM return_requests WHERE request_id = $request_id AND status = 'pending'");
    if ($res->num_rows) {
        $req = $res->fetch_assoc();
        $book_id = $req['book_id'];
        $transaction_id = $req['transaction_id'];

        $conn->query("UPDATE return_requests SET status = 'approved' WHERE request_id = $request_id");
        $conn->query("UPDATE transactions SET return_date = CURDATE(), status = 'returned' WHERE transaction_id = $transaction_id");
        $conn->query("UPDATE books SET available_copies = available_copies + 1 WHERE book_id = '$book_id'");
    }
    header("Location: return_request.php");
    exit();
}

// Reject return
if (isset($_GET['reject'])) {
    $request_id = intval($_GET['reject']);
    $conn->query("UPDATE return_requests SET status = 'rejected' WHERE request_id = $request_id");
    header("Location: return_request.php");
    exit();
}

// Fetch only pending return requests
$query = "
SELECT rr.request_id, rr.request_date, rr.status,
       b.book_id, b.title,
       u.user_id, u.name AS user_name, u.email,
       t.issue_date
FROM return_requests rr
JOIN books b ON rr.book_id = b.book_id
JOIN users u ON rr.user_id = u.user_id
JOIN transactions t ON rr.transaction_id = t.transaction_id
WHERE rr.status = 'pending'
ORDER BY rr.request_date DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Return Requests</title>
  <link rel="stylesheet" href="../css/11style.css">
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
      <a href="return_request.php" class="menu-item active">Return Request</a>
      <a href="manage_books.php" class="menu-item">Manage Books</a>
      <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="return-container">
      <h2>Return Requests</h2>
      <table>
        <thead>
          <tr>
            
            <th>Book</th>
            <th>User</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            
            <th>Status</th>
            <th>Action</th>
            
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
             
              <td><?= htmlspecialchars($row['title']) ?> (<?= $row['book_id'] ?>)</td>
              <td><?= htmlspecialchars($row['user_name']) ?> (<?= $row['email'] ?>)</td>
              <td><?= date("d M Y", strtotime($row['issue_date'])) ?></td>
             
              <td><?= date("d M Y", strtotime($row['request_date'])) ?></td>
              <td><?= ucfirst($row['status']) ?></td>
              <td>
                <a href="return_request.php?approve=<?= $row['request_id'] ?>" class="btn approve">Approve</a>
                <a href="return_request.php?reject=<?= $row['request_id'] ?>" class="btn reject" onclick="return confirm('Reject this return request?')">Reject</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">No pending return requests found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</body>
</html>