<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

if(isset($_POST['book_id'])){
    $book_id = $_POST['book_id'];

    // Delete from books table
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("s", $book_id);

    if($stmt->execute()){
        echo "<script>
                alert('Book Deleted Successfully!');
                window.location.href='delete_book.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting book!');
                window.location.href='delete_book.php';
              </script>";
    }
}
?>
