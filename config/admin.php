<?php
session_start();
require "connection.php"; // Ensure the correct path to your connection file

$errors = array();

// Check if login form is submitted
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query to check if the admin exists
    $check_admin = "SELECT * FROM admin_cred WHERE username = '$username'";
    $res = mysqli_query($con, $check_admin);

    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $stored_password = $fetch['password']; // Hashed password
        $is_temp_password = $fetch['is_temp_password'];
        $temp_password = $fetch['temp_password'];

        // Check if the password is temporary
        if ($is_temp_password == 1 && password_verify($password, $temp_password)) {
            // Temporary password login
            $_SESSION['admin_id'] = $fetch['sr_no'];
            $_SESSION['admin_name'] = $fetch['first_name'];
            $_SESSION['admin_image'] = $fetch['image'];
            $_SESSION['requires_password_change'] = true; // Flag for password change
            header('Location: change-password.php'); // Redirect to change password page
            exit();
        } elseif (password_verify($password, $stored_password)) {
            // Successful login
            $_SESSION['admin_id'] = $fetch['sr_no'];
            $_SESSION['admin_name'] = $fetch['first_name'];
            $_SESSION['admin_image'] = $fetch['image'];
            header('Location: admin-dashboard.php'); // Redirect to dashboard
            exit();
        } else {
            $errors['login'] = "Incorrect password!";
        }
    } else {
        $errors['login'] = "Incorrect username!";
    }
}
?>