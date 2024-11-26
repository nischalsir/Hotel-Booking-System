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
        $stored_password = $fetch['password']; // Hashed password from the database

        // Verify the entered password against the hashed password
        if (password_verify($password, $stored_password)) {
            // Successful login
            $_SESSION['admin_id'] = $fetch['sr_no']; // Store admin ID in session
            $_SESSION['admin_name'] = $fetch['first_name']; // Store admin's first name in session
            $_SESSION['admin_image'] = $fetch['image']; // Store admin's image in session
            header('Location: admin-dashboard.php'); // Redirect to admin dashboard
            exit();
        } else {
            $errors['login'] = "Incorrect password!";
        }
    } else {
        $errors['login'] = "Incorrect username!";
    }
}
?>