<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

$message = "";

// Issue book logic
if(isset($_POST['issue'])){
    $user_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $issue_date = date("Y-m-d");
    $return_date = $_POST['return_date'];

    // Check if book exists and is available
    $book_check = $conn->prepare("SELECT available_copies FROM books WHERE book_id = ?");
    $book_check->bind_param("s", $book_id);
    $book_check->execute();
    $book_check->store_result();

    if($book_check->num_rows > 0){
        $book_check->bind_result($available_copies);
        $book_check->fetch();

        if($available_copies > 0){

            // Insert into issue table
            $stmt = $conn->prepare("INSERT INTO transactions(user_id, book_id, issue_date, return_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user_id, $book_id, $issue_date, $return_date);

            if($stmt->execute()){

                // Reduce available copies
                $update = $conn->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE book_id = ?");
                $update->bind_param("s", $book_id);
                $update->execute();

                $message = "Book Issued Successfully!";
            } else {
                $message = "Error issuing book: ".$stmt->error;
            }

        } else {
            $message = "No available copies left!";
        }
    } else {
        $message = "Invalid Book ID!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issue Book</title>
    <link rel="stylesheet" href="../css/10style.css">
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
            <a href="issue_book.php" class="menu-item active">Issue Book</a>
            <a href="return_request.php" class="menu-item">Return Request</a>
            <a href="manage_books.php" class="menu-item">Manage Books</a>
            <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <form method="POST">
            <div class="form-message">Issue Book</div>

            <input type="text" name="student_id" placeholder="Enter USER ID" required>

            <input type="text" name="book_id" placeholder="Enter Book ID" required>

            <label class="label">Return Date:</label>
            <input type="date" name="return_date" required>

            <button type="submit" name="issue">Issue Book</button>

            <?php if($message) echo "<div class='message'>$message</div>"; ?>
        </form>
    </div>

</div>
</body>
</html>
