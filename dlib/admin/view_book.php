<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

// Fetch all books
$result = $conn->query("SELECT * FROM books ORDER BY book_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <link rel="stylesheet" href="../css/6style.css">
</head>
<body>
<div class="main-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
        <div class="sidebar-menu">
            <a href="add_book.php" class="menu-item">Add Book</a>
            <a href="view_book.php" class="menu-item active">View Book</a>
            <a href="search_book.php" class="menu-item">Search Book</a>
            <a href="modify_book.php" class="menu-item">Modify Book</a>
            <a href="delete_book.php" class="menu-item">Delete Book</a>
            <a href="issue_book.php" class="menu-item">Issue Book</a>
            <a href="return_request.php" class="menu-item">Return Request</a>
            <a href="manage_books.php" class="menu-item">Manage Books</a>
            <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="table-container">
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
                        <th>Total Copies</th>
                        <th>Available Copies</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['edition']}</td>
                        <td>{$row['publisher']}</td>
                        <td>{$row['published_date']}</td>
                        <td>{$row['branch']}</td>
                        <td>{$row['total_copies']}</td>
                        <td>{$row['available_copies']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align:center;'>No books found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
