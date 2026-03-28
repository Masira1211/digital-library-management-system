<?php
include('../db_connect.php');

if(isset($_GET['branch'])){
    $branch = $_GET['branch'];

    $stmt = $conn->prepare("SELECT book_id FROM books WHERE branch=? ORDER BY book_id DESC LIMIT 1");
    $stmt->bind_param("s", $branch);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $last_id = $row['book_id'];
        $num = intval(substr($last_id, 6)) + 1;
    } else {
        $num = 1;
    }

    echo "RYM".$branch.str_pad($num, 4, "0", STR_PAD_LEFT);
}
?>
