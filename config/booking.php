<?php
session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'hotel_booking');

// Check if user is logged in
$is_logged_in = isset($_SESSION['email']);
$profile_pic_path = 'uploads/default_profile_picture.png';  // Default profile picture
$userName = ''; // Default to empty

if ($is_logged_in) {
    // Fetch the user's profile picture and name
    $email = $_SESSION['email'];
    $query = "SELECT profile_picture, name FROM usertable WHERE email = ? LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $profile_pic_path = $user_data['profile_picture'];
        $userName = $user_data['name']; // Fetch the user's name
    }
    $stmt->close();
}

// Initialize variables
$availableRooms = [];
$message = "";

// Fetch available rooms
$sql = "
    SELECT * FROM rooms 
    WHERE availability = 1 
    AND available_rooms > 0
";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $availableRooms[] = $row;
}
$stmt->close();

// Handle room booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_now'])) {
    // Booking data from the form
    $userEmail = $_SESSION['email'] ?? null;
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = $_POST['guests'];

    // Validate input data
    if (!$userEmail) {
        $message = "You must be logged in to make a booking.";
    } elseif (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests)) {
        $message = "Please fill in all the required fields.";
    } elseif (strtotime($checkIn) < strtotime('today') || strtotime($checkOut) <= strtotime($checkIn)) {
        $message = "Check-in date cannot be in the past, and check-out must be after check-in.";
    } else {
        // Check room availability in the rooms table
        $sql = "
            SELECT available_rooms 
            FROM rooms 
            WHERE id = ? AND available_rooms > 0
        ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $stmt->bind_result($availableRoomsCount);
        $stmt->fetch();
        $stmt->close();

        if ($availableRoomsCount <= 0) {
            $message = "Sorry, the selected room is not available.";
        } else {
            // Proceed with booking
            try {
                $con->begin_transaction();

                // Insert booking into the bookings table
                $sql = "INSERT INTO bookings (user_email, room_id, check_in_date, check_out_date, booking_date, guests, status) 
                        VALUES (?, ?, ?, ?, CURDATE(), ?, 'Pending')";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sissi", $userEmail, $roomId, $checkIn, $checkOut, $guests);
                $stmt->execute();

                // Update available rooms count in the rooms table
                $sql = "UPDATE rooms SET available_rooms = available_rooms - 1 WHERE id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $roomId);
                $stmt->execute();

                $con->commit(); // Commit the transaction

                // Send email notification
                $subject = "Booking Confirmation - Under Review";
                $messageBody = "
                    <p>Hello $userName,</p>
                    <p>Thank you for choosing our hotel.</p>
                    <p>Your booking is currently under review. Our support team will contact you shortly to confirm the details of your stay.</p>
                    <p>Booking Details:</p>
                    <ul>
                        <li>Room ID: $roomId</li>
                        <li>Check-In: $checkIn</li>
                        <li>Check-Out: $checkOut</li>
                        <li>Guests: $guests</li>
                    </ul>
                    <p>We look forward to hosting you!</p>
                    <p>Best regards,<br>Hotel Booking System Team</p>
                ";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                $headers .= "From: Hotel Booking System <no-reply@hotelbooking.com>" . "\r\n";

                if (mail($userEmail, $subject, $messageBody, $headers)) {
                    $message = "Booking successful! A confirmation email has been sent.";
                } else {
                    $message = "Booking successful, but email notification failed.";
                }

                echo "<script>
                        alert('$message');
                        window.location.href = 'profile.php';
                    </script>";
            } catch (Exception $e) {
                $con->rollback(); // Roll back the transaction on failure
                $message = "Booking failed. Please try again later.";
            }
        }
    }
}
?>
