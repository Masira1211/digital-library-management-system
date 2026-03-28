<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}

include "../db_connect.php";

$message = "";
$book = null;

if(isset($_POST['search'])){
    $book_id = $_POST['book_id'];

    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("s", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $book = $result->fetch_assoc();
    } else {
        $message = "No book found with ID: $book_id";
    }
}

if(isset($_POST['update'])){
    $book_id = $_POST['book_id'];
    $branch = $_POST['branch'];
    $edition = $_POST['edition'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $published_date = $_POST['published_date'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    $stmt = $conn->prepare("UPDATE books SET 
        branch=?, edition=?, title=?, author=?, publisher=?, 
        published_date=?, total_copies=?, available_copies=? 
        WHERE book_id=?");

    $stmt->bind_param("ssssssiis", $branch, $edition, $title, $author, $publisher,
        $published_date, $total_copies, $available_copies, $book_id);

    if($stmt->execute()){
        $message = "Book updated successfully!";
    } else {
        $message = "Error updating book.";
    }
}

if(isset($_POST['delete'])){
    $book_id = $_POST['book_id'];

    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("s", $book_id);

    if($stmt->execute()){
        $message = "Book deleted successfully!";
        $book = null;
    } else {
        $message = "Error deleting book.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Book</title>
    <link rel="stylesheet" href="../css/8style.css">
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
            <a href="modify_book.php" class="menu-item active">Modify Book</a>
            <a href="delete_book.php" class="menu-item">Delete Book</a>
            <a href="issue_book.php" class="menu-item">Issue Book</a>
            <a href="return_request.php" class="menu-item">Return Request</a>
            <a href="manage_books.php" class="menu-item">Manage Books</a>
            <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        <form method="POST">
            <div class="form-message">Modify Book</div>

            <!-- First Row -->
            <div class="row">
                <input type="text" name="book_id" placeholder="Book ID" value="<?php echo $book['book_id'] ?? ''; ?>" required>
                <select name="branch">
                    <option value="">Branch</option>
                    <?php 
                    $branches = ["CSE","AIML","ECE","EEE","ME","CIVIL","OTHER"];
                    foreach($branches as $b){
                        $sel = ($book && $book['branch']==$b) ? "selected" : "";
                        echo "<option value='$b' $sel>$b</option>";
                    }
                    ?>
                </select>
                <input type="text" name="edition" placeholder="Edition" value="<?= $book['edition'] ?? '' ?>">
            </div>

            <!-- Second Row -->
            <div class="row">
                <input type="text" name="title" placeholder="Book Title" value="<?= $book['title'] ?? '' ?>">
                <input type="text" name="author" placeholder="Author" value="<?= $book['author'] ?? '' ?>">
                <input type="text" name="publisher" placeholder="Publisher" value="<?= $book['publisher'] ?? '' ?>">
            </div>

            <!-- Third Row -->
            <div class="row">
                <input type="date" name="published_date" value="<?= $book['published_date'] ?? '' ?>">
                <input type="number" name="total_copies" placeholder="Total Copies" value="<?= $book['total_copies'] ?? '' ?>">
                <input type="number" name="available_copies" placeholder="Available Copies" value="<?= $book['available_copies'] ?? '' ?>">
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <button type="submit" name="search" class="search-btn">Search</button>
                <button type="submit" name="update" class="update-btn">Update Book</button>
                <button type="submit" name="delete" class="delete-btn">Delete Book</button>
            </div>

            <?php if($message) echo "<div class='message'>$message</div>"; ?>
        </form>

    </div>

</div>

</body>
</html>
