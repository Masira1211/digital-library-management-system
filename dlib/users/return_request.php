<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student','faculty'])) {
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch issued books for logged-in user (status = 'issued')
$sql = "SELECT t.transaction_id, t.book_id, b.title, b.author, t.issue_date, t.return_date
        FROM transactions t
        JOIN books b ON t.book_id = b.book_id
        WHERE t.user_id = ? AND t.status = 'issued'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$issued_books = $stmt->get_result();

// Handle return request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction_id'];
    $book_id = $_POST['book_id'];

    // Insert return request
    $insert = $conn->prepare("INSERT INTO return_requests (transaction_id, book_id, user_id, request_date, status) VALUES (?, ?, ?, NOW(), 'pending')");
    $insert->bind_param("iss", $transaction_id, $book_id, $user_id);

    if ($insert->execute()) {
        $message = "Return request submitted successfully!";
    } else {
        $message = "Error submitting return request: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Request</title>
    <link rel="stylesheet" href="../css/06style.css">
</head>

<body>
<div class="main-layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h1 style="font-size: 24px;">DIGITAL LIBRARY</h1>
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>

        <div class="sidebar-menu">
            <a href="view_book.php" class="menu-item">View Available Books</a>
            <a href="search_book.php" class="menu-item">Search Book</a>
            <a href="issue_request.php" class="menu-item">Issue Book</a>
            <a href="my_books.php" class="menu-item">My Issued Books</a>
            <a href="return_request.php" class="menu-item active">Return Request</a>
             <a href="history.php" class="menu-item">My History</a>
            <a href="feedback.php" class="menu-item">Request/Feedback</a>
            <a href="profile.php" class="menu-item">My Profile</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <div class="table-container">
            <h2>📦 Return Request</h2>

            <?php if ($message): ?>
                <p class="msg"><?= $message ?></p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Issued Date</th>
                        <th>Return Date</th>
                        <th>Request</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($issued_books->num_rows > 0): ?>
                    <?php while ($row = $issued_books->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['book_id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= $row['issue_date'] ?></td>
                            <td><?= $row['return_date'] ?? 'Not returned yet' ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="transaction_id" value="<?= $row['transaction_id'] ?>">
                                    <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                    <button type="submit" class="request-btn">Return</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">No books to return.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
</body>
</html>
