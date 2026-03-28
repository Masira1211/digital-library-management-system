<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

$search_results = [];
$query_text = "";

if(isset($_POST['search'])){
    $query_text = $_POST['query'];

    $stmt = $conn->prepare("SELECT * FROM books 
                            WHERE book_id LIKE ? 
                            OR title LIKE ? 
                            OR author LIKE ?");
    $like = "%".$query_text."%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $search_results[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Book</title>
<link rel="stylesheet" href="../css/7style.css">
</head>

<body>

<div class="main-layout">

    <!-- Sidebar -->
    <div class="sidebar">
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>

        <div class="sidebar-menu">
            <a href="add_book.php" class="menu-item">Add Book</a>
            <a href="view_book.php" class="menu-item">View Book</a>
            <a href="search_book.php" class="menu-item active">Search Book</a>
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

        <div class="search-container">

            <div class="form-message">Search Books</div>

            <form method="POST" class="search-box">
                <input type="text" name="query" value="<?php echo $query_text; ?>" placeholder="Search by Book ID, Title, or Author" required>
                <button type="submit" name="search">Search</button>
            </form>

            <div class="results-box">
                <?php if(isset($_POST['search'])): ?>
                    <?php if(count($search_results) > 0): ?>
                        <?php foreach($search_results as $book): ?>
                            <div class="result-item">
                                <p><strong>ID:</strong> <?php echo $book['book_id']; ?></p>
                                <p><strong>Title:</strong> <?php echo $book['title']; ?></p>
                                <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                                <p><strong>Edition:</strong> <?php echo $book['edition']; ?></p>
                                <p><strong>Publisher:</strong> <?php echo $book['publisher']; ?></p>
                                <p><strong>Published:</strong> <?php echo $book['published_date']; ?></p>
                                <p><strong>Branch:</strong> <?php echo $book['branch']; ?></p>
                                <p><strong>Total Copies:</strong> <?php echo $book['total_copies']; ?></p>
                                <p><strong>Available Copies:</strong> <?php echo $book['available_copies']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-result">No books found.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>

</div>

</body>
</html>
