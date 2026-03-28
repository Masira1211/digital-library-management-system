<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['role'] != 'admin'){
    header("Location: ../loginnout/login.php");
    exit();
}
include "../db_connect.php";

// Delete book (with basic safety)
if (isset($_GET['delete'])) {
    $book_id = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM books WHERE book_id = '$book_id'");
    header("Location: manage_books.php");
    exit();
}

// Fetch single book (for AJAX modal view/edit)
if(isset($_GET['fetch']) && !empty($_GET['fetch'])) {
    $id = $conn->real_escape_string($_GET['fetch']);
    $r = $conn->query("SELECT * FROM books WHERE book_id='$id'");
    if($r->num_rows){
        echo json_encode($r->fetch_assoc());
    } else {
        echo json_encode([]);
    }
    exit();
}

// Handle edit submission
if(isset($_POST['edit_submit'])){
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $edition = $conn->real_escape_string($_POST['edition']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $published_date = $conn->real_escape_string($_POST['published_date']);
    $branch = $conn->real_escape_string($_POST['branch']);
    $total_copies = (int)$_POST['total_copies'];
    $available_copies = (int)$_POST['available_copies'];

    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, edition=?, publisher=?, published_date=?, branch=?, total_copies=?, available_copies=? WHERE book_id=?");
    $stmt->bind_param("ssssssiis", $title, $author, $edition, $publisher, $published_date, $branch, $total_copies, $available_copies, $book_id);
    $stmt->execute();
    header("Location: manage_books.php");
    exit();
}

// Search and optional filter params
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$branch_filter = isset($_GET['branch_filter']) ? $conn->real_escape_string($_GET['branch_filter']) : '';
$availability = isset($_GET['availability']) ? $conn->real_escape_string($_GET['availability']) : '';

$where = [];
if($search !== '') {
    $where[] = "(title LIKE '%$search%' OR author LIKE '%$search%' OR book_id LIKE '%$search%')";
}
if($branch_filter !== '' && $branch_filter !== 'ALL'){
    $where[] = "branch = '$branch_filter'";
}
if($availability !== '' && $availability !== 'ALL'){
    if($availability === 'AVAILABLE') $where[] = "available_copies > 0";
    if($availability === 'ISSUED') $where[] = "available_copies = 0";
}

$where_sql = count($where) ? "WHERE " . implode(" AND ", $where) : "";
$query = "SELECT * FROM books $where_sql ORDER BY published_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <link rel="stylesheet" href="../css/12style.css">
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
            <a href="issue_book.php" class="menu-item">Issue Book</a>
            <a href="return_request.php" class="menu-item">Return Request</a>
            <a href="manage_books.php" class="menu-item active">Manage Books</a>
            <a href="view_feedback.php" class="menu-item">View Request/Feedback</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="manage-container">
            <div class="top-row">
                <form method="GET" class="search-bar">
                    <input type="text" name="search" placeholder="Search by Title, Author, or ID" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </form>

                <div class="filters">
                    <form method="GET" id="filterForm">
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="branch_filter" onchange="document.getElementById('filterForm').submit()">
                            <option value="ALL">All Branches</option>
                            <option value="CSE" <?php if($branch_filter==='CSE') echo 'selected'; ?>>CSE</option>
                            <option value="AIML" <?php if($branch_filter==='AIML') echo 'selected'; ?>>AIML</option>
                            <option value="ECE" <?php if($branch_filter==='ECE') echo 'selected'; ?>>ECE</option>
                            <option value="EEE" <?php if($branch_filter==='EEE') echo 'selected'; ?>>EEE</option>
                            <option value="ME" <?php if($branch_filter==='ME') echo 'selected'; ?>>ME</option>
                            <option value="CIVIL" <?php if($branch_filter==='CIVIL') echo 'selected'; ?>>CIVIL</option>
                            <option value="OTHER" <?php if($branch_filter==='OTHER') echo 'selected'; ?>>OTHER</option>
                        </select>

                        <select name="availability" onchange="document.getElementById('filterForm').submit()">
                            <option value="ALL">All Status</option>
                            <option value="AVAILABLE" <?php if($availability==='AVAILABLE') echo 'selected'; ?>>Available</option>
                            <option value="ISSUED" <?php if($availability==='ISSUED') echo 'selected'; ?>>Issued (0 available)</option>
                        </select>
                    </form>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Branch</th>
                        <th>Total</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($result && $result->num_rows): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo htmlspecialchars($row['branch']); ?></td>
                            <td><?php echo (int)$row['total_copies']; ?></td>
                            <td><?php echo (int)$row['available_copies']; ?></td>
                            <td class="actions">
                                <a href="modify_book.php?id=<?php echo urlencode($row['book_id']); ?>" class="btn edit">Modify</a>
                                <a href="manage_books.php?delete=<?php echo urlencode($row['book_id']); ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($row['title']); ?> (<?php echo $row['book_id']; ?>)?')">Delete</a>
                                <a href="view_book.php?id=<?php echo urlencode($row['book_id']); ?>" class="btn view">View</a>
                                <button class="btn viewmodal" data-id="<?php echo htmlspecialchars($row['book_id']); ?>">Quick View</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center">No books found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Quick View Modal (simple) -->
<div id="quickView" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="q-title"></h3>
        <p><strong>Book ID:</strong> <span id="q-id"></span></p>
        <p><strong>Author:</strong> <span id="q-author"></span></p>
        <p><strong>Edition:</strong> <span id="q-edition"></span></p>
        <p><strong>Publisher:</strong> <span id="q-publisher"></span></p>
        <p><strong>Published Date:</strong> <span id="q-pubdate"></span></p>
        <p><strong>Branch:</strong> <span id="q-branch"></span></p>
        <p><strong>Total Copies:</strong> <span id="q-total"></span></p>
        <p><strong>Available Copies:</strong> <span id="q-available"></span></p>
    </div>
</div>

<script>
function closeModal(){
    document.getElementById('quickView').style.display = 'none';
}
document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('viewmodal')){
        var id = e.target.getAttribute('data-id');
        fetch('manage_books.php?fetch=' + encodeURIComponent(id))
            .then(r => r.json())
            .then(data => {
                if(Object.keys(data).length){
                    document.getElementById('q-title').innerText = data.title || '';
                    document.getElementById('q-id').innerText = data.book_id || '';
                    document.getElementById('q-author').innerText = data.author || '';
                    document.getElementById('q-edition').innerText = data.edition || '';
                    document.getElementById('q-publisher').innerText = data.publisher || '';
                    document.getElementById('q-pubdate').innerText = data.published_date || '';
                    document.getElementById('q-branch').innerText = data.branch || '';
                    document.getElementById('q-total').innerText = data.total_copies || '';
                    document.getElementById('q-available').innerText = data.available_copies || '';
                    document.getElementById('quickView').style.display = 'block';
                } else {
                    alert('Book details not found.');
                }
            }).catch(()=> alert('Failed to fetch details.'));
    }
});

// close modal on outside click
window.addEventListener('click', function(e){
    if(e.target === document.getElementById('quickView')) closeModal();
});
</script>

</body>
</html>