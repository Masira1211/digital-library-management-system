<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logout Confirmation</title>
  <link rel="stylesheet" href="css/14style.css">
</head>
<body>

<div class="logout-box">
  <h2>Are you sure you want to logout?</h2>
  <form method="POST" action="process_logout.php">
    <button type="submit" name="confirm" class="btn confirm">Yes, Logout</button>
    <button type="submit" name="cancel" class="btn cancel">No, Go Back</button>
  </form>
</div>

</body>
</html>