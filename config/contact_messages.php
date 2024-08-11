<?php
session_start();
require "connection.php";

$errors = array();
$success = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        $insert_data = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($con, $insert_data)) {
            $subject = "Thank you for contacting us!";
            $email_message = "Dear $name,<br><br>Thank you for reaching out to us. We have received your message and will get back to you shortly.<br><br>Best regards,<br>Hotel Booking System";
            $headers = "From: no-reply@hotelbookingsystem.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if (mail($email, $subject, $email_message, $headers)) {
                $success = "Your message has been sent successfully. Thank you for contacting us!";
            } else {
                $errors[] = "Failed to send thank you message.";
            }
        } else {
            $errors[] = "Failed to insert data into database.";
        }
    }
}
?>