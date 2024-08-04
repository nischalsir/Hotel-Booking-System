<?php
session_start();
require "connection.php"; // Make sure this path is correct

$errors = array();

// Check if login form is submitted
if (isset($_POST['login'])) {
    $admin_name = mysqli_real_escape_string($con, $_POST['admin_name']);
    $admin_pass = mysqli_real_escape_string($con, $_POST['admin_pass']);

    // Query to check if the admin exists
    $check_admin = "SELECT * FROM admin_cred WHERE admin_name = '$admin_name'";
    $res = mysqli_query($con, $check_admin);

    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['admin_pass'];

        // Compare the entered password with the fetched password
        if ($admin_pass === $fetch_pass) {
            // Successful login
            $_SESSION['admin_name'] = $admin_name;
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