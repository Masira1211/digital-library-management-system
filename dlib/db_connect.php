<?php
$servername = "localhost";
$username = "root";      // change if you have a different MySQL username
$password = "";          // add password if set in XAMPP or MySQL
$database = "diglib";    // your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: uncomment below line to show success message during testing
// echo "Connected successfully!";
?>
