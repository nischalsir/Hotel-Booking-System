<?php
session_start();
// Check if user is logged in
$is_logged_in = isset($_SESSION['email']);
?>
<?php
// Include the database connection
include('connection.php');

// Initialize variables
$availableRooms = [];
$message = "";

// Retrieve all available rooms
$sql = "
    SELECT * FROM rooms 
    WHERE availability = 1 
    AND id NOT IN (
        SELECT room_id FROM bookings 
        WHERE 
            (check_in_date <= CURDATE() AND check_out_date >= CURDATE())
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
    $userId = $_SESSION['user_id'] ?? null; // Retrieve the logged-in user ID from session
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = $_POST['guests'];

    // Validate input data
    if (!$userId) {
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
            AND status = 'Pending'
            AND (
                (check_in_date <= ? AND check_out_date > ?) OR
                (check_in_date < ? AND check_out_date >= ?)
            )";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issss", $roomId, $checkOut, $checkIn, $checkOut, $checkIn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "The selected room is not available for the chosen dates.";
        } else {
            // Insert booking into the bookings table
            $sql = "INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, booking_date, guests, status) 
                    VALUES (?, ?, ?, ?, CURDATE(), ?, 'Pending')";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iissi", $userId, $roomId, $checkIn, $checkOut, $guests);

            if ($stmt->execute()) {
                $message = "Booking successful! Please make a payment at the hotel and bring a valid ID.";
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
?>