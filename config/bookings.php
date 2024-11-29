<?php
// Include database connection
require "../config/connection.php";

$from_email = "no-reply@hotelbookingsystem.com"; // Replace with a valid email address
$from_name = "Hotel Booking System"; // Sender name

// Fetch booking data with necessary joins
$query = "
    SELECT 
        b.id AS booking_id,
        u.name AS user_name,
        u.email AS user_email,
        u.phone AS user_phone,
        r.room_type AS room_name,
        r.id AS room_id,
        b.guests,
        b.check_in_date,
        b.check_out_date,
        b.status
    FROM bookings AS b
    JOIN usertable AS u ON b.user_email = u.email
    JOIN rooms AS r ON b.room_id = r.id
    ORDER BY b.created_at DESC";
$result = mysqli_query($con, $query);

// Handle approve and cancel actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $room_id = intval($_POST['room_id']); // Capture room ID from the form
    $user_email = $_POST['user_email']; // Capture user email from the form
    $user_name = $_POST['user_name']; // Capture user name from the form

    // Email headers
    $headers = "From: $from_name <$from_email>\r\n";
    $headers .= "Reply-To: $from_email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (isset($_POST['approve'])) {
        // Approve the booking
        $update_query = "UPDATE bookings SET status = 'Confirmed' WHERE id = $booking_id";
        if (!mysqli_query($con, $update_query)) {
            die("Error approving booking: " . mysqli_error($con));
        }

        // Decrement available_rooms in the rooms table
        $decrement_room_query = "UPDATE rooms SET available_rooms = available_rooms - 1 WHERE id = $room_id";
        if (!mysqli_query($con, $decrement_room_query)) {
            die("Error updating rooms: " . mysqli_error($con));
        }

        // Check if user is booking for the first time
        $check_first_time_query = "SELECT COUNT(*) AS booking_count FROM bookings WHERE user_email = '$user_email' AND status = 'Confirmed'";
        $result = mysqli_query($con, $check_first_time_query);
        $data = mysqli_fetch_assoc($result);

        $subject = "Booking Approved";
        $message = "Dear $user_name,\n\nYour booking has been approved.\n\nThank you for choosing our service.\n";

        if ($data['booking_count'] == 1) {
            // Generate a random discount code
            $discount_code = strtoupper(substr(md5(time() . rand()), 0, 8)); // Random 8-character code

            // Save the discount code to the database
            $insert_discount_query = "
                INSERT INTO discount_codes (user_email, discount_code, discount_percentage)
                VALUES ('$user_email', '$discount_code', 40)";
            if (!mysqli_query($con, $insert_discount_query)) {
                die("Error inserting discount code: " . mysqli_error($con));
            }

            // Append discount code information to the email
            $message .= "\nAs a first-time customer, you are eligible for a 40% discount on your next booking!\n";
            $message .= "Your discount code: $discount_code\n\n";
        }

        $message .= "Best regards,\nHotel Booking System";

        // Send single email
        mail($user_email, $subject, $message, $headers);

    } elseif (isset($_POST['cancel'])) {
        // Cancel the booking
        $update_query = "UPDATE bookings SET status = 'Cancelled' WHERE id = $booking_id";
        if (!mysqli_query($con, $update_query)) {
            die("Error canceling booking: " . mysqli_error($con));
        }

        // Increment available_rooms in the rooms table
        $increment_room_query = "UPDATE rooms SET available_rooms = available_rooms + 1 WHERE id = $room_id";
        if (!mysqli_query($con, $increment_room_query)) {
            die("Error updating rooms: " . mysqli_error($con));
        }

        // Send cancellation email
        $subject = "Booking Cancelled";
        $message = "Dear $user_name,\n\nYour booking has been cancelled.\n\nIf you have any questions, feel free to contact us.\n\nBest regards,\nHotel Booking System";
        mail($user_email, $subject, $message, $headers);
    }

    // Redirect to avoid duplicate form submissions
    header("Location: bookings.php");
    exit();
}
?>