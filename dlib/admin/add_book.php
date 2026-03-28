<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

// Initialize message & popup variable
$message = "";
$popup_id = "";

// Handle form submission
if(isset($_POST['submit'])){
    $branch = $_POST['branch'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];
    $published_date = $_POST['published_date'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    // Generate Book ID
    $prefix = "RYM" . strtoupper($branch);
    $result = $conn->query("SELECT book_id FROM books WHERE book_id LIKE '$prefix%' ORDER BY book_id DESC LIMIT 1");
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $last_id = intval(substr($row['book_id'], strlen($prefix))) + 1;
        $book_id = $prefix . str_pad($last_id, 4, '0', STR_PAD_LEFT);
    } else {
        $book_id = $prefix . "0001";
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO books(book_id, title, author, edition, publisher, published_date, branch, total_copies, available_copies) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssii", $book_id, $title, $author, $edition, $publisher, $published_date, $branch, $total_copies, $available_copies);

    if($stmt->execute()){
        $message = "Book added successfully!";
        $popup_id = $book_id;  // store for popup
    } else {
        $message = "Error adding book: ".$stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
    <link rel="stylesheet" href="../css/5style.css">
</head>
<body>

<?php if(!empty($popup_id)): ?>
<script>
    alert("Book Added Successfully!\nGenerated Book ID: <?php echo $popup_id; ?>");
</script>
<?php endif; ?>

<div class="main-layout">

    <!-- Sidebar -->
    <div class="sidebar">
       

        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>

        <div class="sidebar-menu">
            <a href="add_book.php" class="menu-item active">Add Book</a>
            <a href="view_book.php" class="menu-item">View Book</a>
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
        <form method="POST">
            <div class="form-message">Add Book Details</div>

            <div class="row">
                <select name="branch" required>
                    <option value="">Select Branch</option>
                    <option value="CSE">CSE</option>
                    <option value="AIML">AIML</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                    <option value="ME">ME</option>
                    <option value="CIVIL">CIVIL</option>
                    <option value="OTHER">OTHER</option>
                </select>

                <input type="text" name="edition" placeholder="Edition" required>
            </div>

            <input type="text" name="title" placeholder="Book Title" required>
            <input type="text" name="author" placeholder="Author">
            <input type="text" name="publisher" placeholder="Publisher">
            <input type="date" name="published_date">

            <div class="row">
                <input type="number" name="total_copies" placeholder="Total Copies" min="1" required>
                <input type="number" name="available_copies" placeholder="Available Copies" min="1" required>
            </div>

            <button type="submit" name="submit">Add Book</button>

            <?php if($message) echo "<div class='message'>$message</div>"; ?>
        </form>
    </div>

</div>
</body>
</html>
