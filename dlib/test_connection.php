<?php
include 'db_connect.php';

if ($conn) {
    echo "<h2 style='color:green; text-align:center; margin-top:50px;'>Database Connection Successful ✅</h2>";
} else {
    echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Database Connection Failed ❌</h2>";
}
?>
