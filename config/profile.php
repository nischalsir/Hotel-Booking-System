<?php
session_start();
include('../config/connection.php');
$is_logged_in = isset($_SESSION['email']);
$profile_pic_path = 'uploads/default_profile_picture.png';  // Default image if not set

if ($is_logged_in) {
    // Get the user's profile picture from the database
    $email = $_SESSION['email'];  // User's email stored in session
    $query = "SELECT profile_picture FROM usertable WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $profile_pic_path = $user_data['profile_picture'];  // Retrieve the profile picture path
    }
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login-user.php");
    exit();
}

// Get logged-in user's email
$email = $_SESSION['email'];

// Fetch user data from database
$sql = "SELECT * FROM usertable WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch user bookings
$sql = "SELECT * FROM bookings WHERE user_email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$bookings = $stmt->get_result();
$stmt->close();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $profile_picture = $_FILES['profile_picture'];

    // Validate and handle profile picture upload
    if ($profile_picture && $profile_picture['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $profile_picture['tmp_name'];
        $fileName = $profile_picture['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
    
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
            // Corrected upload directory path
            $uploadDir = __DIR__ . '/../public/uploads/';
            $destPath = $uploadDir . $newFileName;
    
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Save the full path in the database
                $profile_pic_path = 'uploads/' . $newFileName;
    
                $sql = "UPDATE usertable SET name = ?, phone = ?, profile_picture = ? WHERE email = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssss", $name, $phone, $profile_pic_path, $email);
    
                if ($stmt->execute()) {
                    $message = "Profile updated successfully!";
                } else {
                    $message = "Failed to update profile.";
                }

            } else {
                error_log("File upload failed. Path: $destPath");
                $message = "Failed to upload profile picture.";
            }
        } else {
            $message = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }
     else {
        $sql = "UPDATE usertable SET name = ?, phone = ? WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $name, $phone, $email);
    }

    if (isset($stmt) && $stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Failed to update profile.";
    }
    $stmt->close();
}

// Handle booking update or cancel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
  $bookingId = $_POST['booking_id'];

  // Cancel the booking
  $sql = "UPDATE bookings SET status = 'Cancelled' WHERE id = ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("i", $bookingId);
  if ($stmt->execute()) {
      // Send an apology email
      $subject = "Booking Cancellation Apology";
      $email_message = "Dear {$user['name']},<br><br>We are sorry to inform you that your booking has been cancelled. We sincerely apologize for any inconvenience caused. Please feel free to reach out to us for further assistance.<br><br>Best regards,<br>Hotel Booking System";
      $headers = "From: no-reply@hotelbookingsystem.com\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      if (mail($email, $subject, $email_message, $headers)) {
          $message = "Booking cancelled successfully! Apology email has been sent.";
      } else {
          $message = "Booking cancelled, but failed to send apology email.";
      }
  } else {
      $message = "Failed to cancel booking.";
  }
  $stmt->close();

  // Redirect back to the profile page with success message
  header("Location: profile.php");
  exit();
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
  $rating = intval($_POST['rating']);
  $comment = $_POST['comment'];
  $review_email = $_SESSION['email']; // Logged-in user's email

  $sql = "INSERT INTO reviews (user_email, rating, comment) VALUES (?, ?, ?)";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("sis", $review_email, $rating, $comment);

  if ($stmt->execute()) {
      $review_message = "Review submitted successfully!";
  } else {
      $review_message = "Failed to submit review.";
  }
  $stmt->close();
}

// Fetch user reviews
$sql = "SELECT * FROM reviews WHERE user_email = ? ORDER BY created_at DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$user_reviews = $stmt->get_result();
$stmt->close();

// Delete Review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
  $review_id = intval($_POST['review_id']);
  $user_email = $_SESSION['email']; // Get the logged-in user's email

  // Delete the review if it belongs to the logged-in user
  $stmt = $con->prepare("DELETE FROM reviews WHERE id = ? AND user_email = ?");
  $stmt->bind_param("is", $review_id, $user_email);

  if ($stmt->execute()) {
      $_SESSION['message'] = "Review deleted successfully!";
  } else {
      $_SESSION['message'] = "Failed to delete review.";
  }

  $stmt->close();
  $con->close();

  header("Location: profile.php");
  exit;
}
?>