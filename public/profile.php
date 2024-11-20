<?php
session_start();
include('../config/connection.php');

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
    $profilePicture = $_FILES['profile_picture']['name'];

    // Handle profile picture upload
    if ($profilePicture) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($profilePicture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile);
        $sql = "UPDATE usertable SET name = ?, phone = ?, profile_picture = ? WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $name, $phone, $profilePicture, $email);
    } else {
        $sql = "UPDATE usertable SET name = ?, phone = ? WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $name, $phone, $email);
    }

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Failed to update profile.";
    }
    $stmt->close();
}

// Handle booking update or cancel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_booking'])) {
    $bookingId = $_POST['booking_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $status = $_POST['status'];

    if ($status === 'Cancel') {
        // Cancel booking
        $sql = "UPDATE bookings SET status = 'Cancelled' WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $stmt->close();

        // Send apology email
        $subject = "Booking Cancellation Apology";
        $email_message = "Dear $user[name],<br><br>We are sorry to inform you that your booking has been cancelled. We sincerely apologize for any inconvenience caused. Please feel free to reach out to us for any further assistance.<br><br>Best regards,<br>Hotel Booking System";
        $headers = "From: no-reply@hotelbookingsystem.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($email, $subject, $email_message, $headers)) {
            $message = "Booking cancelled successfully! Apology email has been sent.";
        } else {
            $message = "Booking cancelled, but failed to send apology email.";
        }
    } else {
        // Update booking
        $sql = "UPDATE bookings SET check_in_date = ?, check_out_date = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $checkIn, $checkOut, $bookingId);
        $stmt->execute();
        $stmt->close();
        $message = "Booking updated successfully!";
    }

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to preview image before uploading
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</head>
<body>
  <nav>
    <div class="logo">HBS</div>
    <ul class="nav-links">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="book.php">Rooms</a></li>
      <li class="nav-link"><a href="facilities.php">Facilities</a></li>
      <li class="nav-link"><a href="contact.php">Contact</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
    </ul>
  </nav>
  <section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- signup container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-4xl w-full p-8">
      <!-- form -->
      <div class="w-full">
        <h2 class="font-bold text-2xl text-[#002D74] text-center">User Profile</h2>
        <p class="text-xs mt-4 text-[#002D74] text-center">Here you can see your info and manage your profile.</p>
        <br>
        <form action="profile.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="flex flex-col gap-6">
          <div class="flex items-center gap-4">
            <div class="col-span-full">
              <label for="photo" class="block text-sm/6 font-medium text-gray-700">Photo</label>
              <div class="mt-2 flex items-center gap-x-3">
                <!-- Update image path dynamically -->
                <img id="imagePreview" class="h-12 w-12 rounded-full object-cover border border-gray-300" alt="profile picture" src="<?php echo $profilePicture; ?>">
                <label class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                  Upload
                  <input type="file" name="profile_picture" id="profile_picture" class="hidden" onchange="previewImage(event)" required>
                </label>
              </div>
            </div>
          </div>
          <label for="name" class="block text-sm/6 font-medium text-gray-700">Name</label>
          <input class="p-3 rounded-xl border" type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

          <label for="phone" class="block text-sm/6 font-medium text-gray-700">Phone Number</label>
          <input class="p-3 rounded-xl border" type="number" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>

          <button class="bg-[#002D74] rounded-xl text-white py-3 hover:scale-105 duration-300" type="submit" name="update_profile">Update Profile</button>
        </form>
        <h3><?php echo $message ?? ''; ?></h3>
      </div>
    </div>
  </section>

  <div>
    <h2>Your Bookings</h2>
    <?php if ($bookings->num_rows > 0): ?>
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left">Room ID</th>
            <th class="px-4 py-2 text-left">Check-in Date</th>
            <th class="px-4 py-2 text-left">Check-out Date</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($booking = $bookings->fetch_assoc()): ?>
            <tr>
              <td class="px-4 py-2"><?php echo $booking['room_id']; ?></td>
              <td class="px-4 py-2"><?php echo $booking['check_in_date']; ?></td>
              <td class="px-4 py-2"><?php echo $booking['check_out_date']; ?></td>
              <td class="px-4 py-2"><?php echo $booking['status']; ?></td>
              <td class="px-4 py-2">
                <form action="profile.php" method="POST">
                  <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                  <input type="text" name="check_in" value="<?php echo $booking['check_in_date']; ?>" required>
                  <input type="text" name="check_out" value="<?php echo $booking['check_out_date']; ?>" required>
                  <select name="status" required>
                    <option value="Update">Update</option>
                    <option value="Cancel">Cancel</option>
                  </select>
                  <button type="submit" name="update_booking">Submit</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No bookings found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
