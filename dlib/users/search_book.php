<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}

$keyword = "";
$results = null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    if ($keyword === "") {
        $message = "Please enter a search term.";
    } else {
        $like = "%".$keyword."%";
        $sql = "SELECT * FROM books WHERE 
                    title LIKE ? OR 
                    author LIKE ? OR 
                    book_id LIKE ? OR
                    publisher LIKE ? OR
                    edition LIKE ? OR
                    published_date LIKE ? OR
                    branch LIKE ?
                ORDER BY book_id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $like, $like, $like, $like, $like, $like, $like);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows === 0) {
            $message = "No books found for \"".htmlspecialchars($keyword)."\".";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Book</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/03style.css">
</head>
<body>

<div class="main-layout">
  <div class="sidebar">
    <h1 style="font-size: 24px;">DIGITAL LIBRARY</h1>
    <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    <div class="sidebar-menu">
      <a href="view_book.php" class="menu-item">View Available Books</a>
      <a href="search_book.php" class="menu-item active">Search Book</a>
      <a href="issue_request.php" class="menu-item">Issue Book</a>
      <a href="my_books.php" class="menu-item">My Issued Books</a>
      <a href="return_request.php" class="menu-item">Return Request</a>
       <a href="history.php" class="menu-item">My History</a>
      <a href="feedback.php" class="menu-item">Request/Feedback</a>
      <a href="profile.php" class="menu-item">My Profile</a>
    </div>
  </div>

  <div class="content">
    <form method="POST" class="search-form">
      <div class="form-header">
        <h2>🔍 Search Books</h2>
        <p>Find books by title, author, ID, publisher, edition, date, or branch</p>
      </div>

      <div class="row">
        <input type="text" name="keyword" placeholder="Enter Title / Author / Book ID / Publisher / Edition / Date / Branch" value="<?= htmlspecialchars($keyword) ?>" required>
      </div>

      <div class="button-row">
        <button type="submit" class="btn-primary">Search</button>
        <button type="button" class="btn-secondary" onclick="document.querySelector('input[name=keyword]').value='';">Clear</button>
      </div>

      <?php if ($message): ?>
        <p class="message error"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>
    </form>

    <?php if ($results && $results->num_rows > 0): ?>
      <div class="table-wrap">
        <div class="scroll-box">
          <table class="results-table">
            <thead>
              <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Publisher</th>
                <th>Published Date</th>
                <th>Branch</th>
                <th>Total</th>
                <th>Available</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $results->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['book_id']) ?></td>
                  <td><?= htmlspecialchars($row['title']) ?></td>
                  <td><?= htmlspecialchars($row['author']) ?></td>
                  <td><?= htmlspecialchars($row['edition']) ?></td>
                  <td><?= htmlspecialchars($row['publisher']) ?></td>
                  <td><?= htmlspecialchars($row['published_date']) ?></td>
                  <td><?= htmlspecialchars($row['branch']) ?></td>
                  <td><?= htmlspecialchars($row['total_copies']) ?></td>
                  <td><?= htmlspecialchars($row['available_copies']) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>