<?php
session_start();
include "db_connect.php";

// ✅ Set timezone to IST
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['confirm'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $logout_time = date('Y-m-d H:i:s'); // now in IST

        $stmt = $conn->prepare("UPDATE users SET last_logout = ? WHERE email = ?");
        $stmt->bind_param("ss", $logout_time, $email);
        $stmt->execute();
    }

    session_unset();
    session_destroy();

    header("Location: loginnout/login.php");
    exit();
}

if (isset($_POST['cancel'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: users/dashboard.php");
    }
    exit();
}