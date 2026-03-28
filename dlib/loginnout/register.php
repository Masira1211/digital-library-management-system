<?php
session_start();
include('../db_connect.php');

$message = "";
$error = "";
$generated_user_id = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $verify_password = $_POST['verify_password'];
    $branch = strtoupper($_POST['branch']);
    $role = strtolower($_POST['role']); // admin/student/faculty

    if($password !== $verify_password){
        $error = "Passwords do not match.";
    } 
    else 
    {
        // Check email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $error = "Email already registered.";
        } 
        else 
        {
            // --- ROLE LETTER ---
            $role_letter = "";
            if($role == "admin") $role_letter = "A";
            if($role == "student") $role_letter = "S";
            if($role == "faculty") $role_letter = "F";

            // --- Generate prefix RYM + branch + role letter ---
            $prefix = "RYM" . $branch . $role_letter;

            // --- Get last user_id starting with prefix ---
            $sql = "SELECT user_id FROM users WHERE user_id LIKE '$prefix%' ORDER BY user_id DESC LIMIT 1";
            $res = $conn->query($sql);

            if($res->num_rows > 0){
                $last_id = $res->fetch_assoc()['user_id'];
                $last_num = intval(substr($last_id, strlen($prefix))); 
                $new_num = $last_num + 1;
            } else {
                $new_num = 1;
            }

            // --- Final user ID ---
            $generated_user_id = $prefix . str_pad($new_num, 4, "0", STR_PAD_LEFT);

            // Insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $status = "pending";

            $stmt = $conn->prepare("INSERT INTO users (user_id,name,email,passwords,role,status,branch) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $generated_user_id, $name, $email, $hashed_password, $role, $status, $branch);

            if($stmt->execute()){
                $message = "Registered successfully! Your User ID is: <b>$generated_user_id</b><br>Wait for admin approval.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="../css/2style.css">
</head>
<body>
<div class="wrapper">
    <div class="container">
        <h1>Register</h1>

        <?php if($error != ""): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($message != ""): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">

            <input type="text" name="name" required placeholder="Full Name">
            <input type="email" name="email" required placeholder="Email">

            <div class="row">
                <input type="password" name="password" required placeholder="Password">
                <input type="password" name="verify_password" required placeholder="Verify Password">
            </div>

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

                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" name="register">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>
</body>
</html>
