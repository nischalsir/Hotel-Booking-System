<?php
session_start();
// Check if user is logged in
$is_logged_in = isset($_SESSION['email']);
?>
<?php
$con = mysqli_connect('localhost', 'root', '', 'hotel_booking');
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
?>
<?php
// Include the database connection
include('../config/connection.php');

// Initialize variables
$availableRooms = [];
$message = "";

// Retrieve all available rooms that have availability > 0 and include canceled rooms
$sql = "
    SELECT * FROM rooms 
    WHERE availability = 1 
    AND id NOT IN (
        SELECT room_id FROM bookings 
        WHERE 
            (check_in_date <= CURDATE() AND check_out_date >= CURDATE()) AND 
            status != 'Cancelled'
    )";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Fetch available rooms
while ($row = $result->fetch_assoc()) {
    $availableRooms[] = $row;
}
$stmt->close();

// Handle room booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_now'])) {
    // Booking data from the form
    $userEmail = $_SESSION['email'] ?? null; // Retrieve the logged-in user's email from session
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = $_POST['guests'];

    // Validate input data
    if (!$userEmail) {
        $message = "You must be logged in to make a booking.";
    } elseif (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests)) {
        $message = "Please fill in all the required fields.";
    } elseif ($checkIn >= $checkOut) {
        $message = "Check-out date must be later than check-in date.";
    } else {
        // Check for room availability in the given date range
        $sql = "
            SELECT * FROM bookings 
            WHERE room_id = ? 
            AND status != 'Cancelled' 
            AND (
                (check_in_date <= ? AND check_out_date > ?) OR 
                (check_in_date < ? AND check_out_date >= ?)
            )
        ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issss", $roomId, $checkOut, $checkIn, $checkOut, $checkIn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "The selected room is not available for the chosen dates.";
        } else {
            // Check for room availability in the rooms table
            $sql = "
                SELECT available_rooms FROM rooms 
                WHERE id = ? 
                AND available_rooms > 0
            ";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $roomId);
            $stmt->execute();
            $stmt->bind_result($availableRoomsCount);
            $stmt->fetch();
            $stmt->close();

            if ($availableRoomsCount <= 0) {
                $message = "Sorry, no rooms are available for the selected type.";
            } else {
                // Insert booking into the bookings table
                $sql = "INSERT INTO bookings (user_email, room_id, check_in_date, check_out_date, booking_date, guests, status) 
                        VALUES (?, ?, ?, ?, CURDATE(), ?, 'Pending')";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sissi", $userEmail, $roomId, $checkIn, $checkOut, $guests);

                if ($stmt->execute()) {
                    // Update the available rooms count after booking
                    $newAvailableRooms = $availableRoomsCount - 1;
                    $sql = "UPDATE rooms SET available_rooms = ? WHERE id = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("ii", $newAvailableRooms, $roomId);
                    $stmt->execute();

                    // Send email notification to the user
                    $subject = "Booking Confirmation - Under Review";
                    $messageBody = "
                        <p>Hello,</p>
                        <p>Your booking has been successfully submitted and is currently under review.</p>
                        <p>A hotel employee will contact you shortly to confirm the details of your booking.</p>
                        <p>Thank you for choosing our hotel!</p>
                    ";
                    $sender = "From: Hotel Booking System <no-reply@hotelbooking.com>";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                    $headers .= $sender . "\r\n";
 
                    if (mail($userEmail, $subject, $messageBody, $headers)) {
                        $message = "Booking successful! A confirmation email has been sent. Please wait for the hotel employee to contact you shortly.";
                    } else {
                        $message = "Booking successful, but we failed to send the confirmation email.";
                    }

                    echo "<script>
                            alert('$message');
                            window.location.href = 'profile.php';
                        </script>";
                } else {
                    $message = "Booking failed. Please try again later.";
                }
                $stmt->close();
            }
        }
    }
}
?>
