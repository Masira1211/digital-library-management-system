<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

$message = "";
$bookData = null;

// Search book
if(isset($_POST['search'])){
    $search = trim($_POST['search_value']);

    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ? OR title LIKE ?");
    $like = "%$search%";
    $stmt->bind_param("ss", $search, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $bookData = $result->fetch_assoc();
    } else {
        $message = "No book found!";
    }
}

// Delete book
if(isset($_POST['delete'])){
    $book_id = $_POST['book_id'];

    // Check if issued
    $check = $conn->prepare("SELECT * FROM issued_books WHERE book_id = ?");
    $check->bind_param("s", $book_id);
    $check->execute();
    $issued_result = $check->get_result();

    if($issued_result->num_rows > 0){
        $message = "Cannot delete! Book is currently issued.";
    } else {
        $del = $conn->prepare("DELETE FROM books WHERE book_id = ?");
        $del->bind_param("s", $book_id);

        if($del->execute()){
            $message = "Book deleted successfully!";
            $bookData = null;
        } else {
            $message = "Error deleting book!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Book</title>
    <link rel="stylesheet" href="../css/9style.css">
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
            <a href="delete_book.php" class="menu-item active">Delete Book</a>
            <a href="issue_book.php" class="menu-item">Issue Book</a>
            <a href="return_request.php" class="menu-item">Return Request</a>
            <a href="manage_books.php" class="menu-item">Manage Books</a>
            <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        <form method="POST">
            <div class="form-message">Delete Book</div>

            <!-- Search Row (same style as Add Book rows) -->
            <div class="row">
                <input type="text" name="search_value" placeholder="Enter Book ID" required>
                <button type="submit" name="search" class="small-btn">Search</button>
                <button type="button" onclick="window.location.href='delete_book.php'" class="small-btn">Clear</button>
            </div>

            <?php if($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Show table only if search result exists -->
            <?php if($bookData): ?>
                <table class="result-table">
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Branch</th>
                        <th>Action</th>
                    </tr>

                    <tr>
                        <td><?php echo $bookData['book_id']; ?></td>
                        <td><?php echo $bookData['title']; ?></td>
                        <td><?php echo $bookData['author']; ?></td>
                        <td><?php echo $bookData['branch']; ?></td>
                        <td>
                            <!-- DELETE BUTTON -->
                            <button type="submit" name="delete" value="1" class="delete-btn"
                                <?php
                                    // disable button if issued
                                    $check = $conn->prepare("SELECT * FROM transactions WHERE book_id = ?");
                                    $check->bind_param("s", $bookData['book_id']);
                                    $check->execute();
                                    $res = $check->get_result();
                                    if($res->num_rows > 0) echo "disabled";
                                ?>>
                                Delete
                            </button>
                            <input type="hidden" name="book_id" value="<?php echo $bookData['book_id']; ?>">
                        </td>
                    </tr>
                </table>
            <?php endif; ?>

        </form>

    </div>
</div>

</body>
</html>
