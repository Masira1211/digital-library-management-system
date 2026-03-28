<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: modify_book.php");
    exit();
}

$action = $_POST['action'] ?? '';
$original = $_POST['original_book_id'] ?? '';

if($action === 'delete'){
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("s", $original);

    if($stmt->execute()){
        header("Location: modify_book.php?msg=" . urlencode("Book deleted successfully."));
    } else {
        header("Location: modify_book.php?msg=" . urlencode("Error deleting book."));
    }
    exit();
}

if($action === 'update') {

    // NEW VALUES
    $new_id = trim($_POST['book_id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $edition = trim($_POST['edition']);
    $publisher = trim($_POST['publisher']);
    $published_date = trim($_POST['published_date']);
    $branch = trim($_POST['branch']);
    $total_copies = intval($_POST['total_copies']);
    $available_copies = intval($_POST['available_copies']);

    if(empty($new_id) || empty($title)){
        header("Location: modify_book.php?msg=" . urlencode("Book ID and Title are required."));
        exit();
    }

    // --- FIXED DUPLICATE ID CHECK ---
    if($new_id !== $original){
        $check = $conn->prepare("SELECT book_id FROM books WHERE book_id = ?");
        $check->bind_param("s", $new_id);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){
            header("Location: modify_book.php?msg=" . urlencode("The Book ID '$new_id' already exists. Use another ID."));
            exit();
        }
    }

    // --- SAFE UPDATE (NO DUPLICATE POSSIBLE NOW) ---
    $stmt = $conn->prepare("
        UPDATE books SET 
            book_id=?, 
            title=?, 
            author=?, 
            edition=?, 
            publisher=?, 
            published_date=?, 
            branch=?, 
            total_copies=?, 
            available_copies=?
        WHERE book_id=?
    ");

    $stmt->bind_param("ssssssssss", 
        $new_id, 
        $title, 
        $author, 
        $edition, 
        $publisher, 
        $published_date, 
        $branch, 
        $total_copies, 
        $available_copies, 
        $original
    );

    if($stmt->execute()){
        header("Location: modify_book.php?book_id=" . urlencode($new_id) . "&msg=" . urlencode("Book updated successfully."));
    } else {
        header("Location: modify_book.php?msg=" . urlencode("Update error: " . $stmt->error));
    }

    exit();
}

header("Location: modify_book.php");
exit();
