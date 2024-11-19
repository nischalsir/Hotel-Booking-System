<?php
session_start();
include('../config/connection.php');

// Fetch user details from the session
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $con->query($query);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Welcome, <?php echo $user['full_name']; ?></h1>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Phone: <?php echo $user['phone']; ?></p>
    <h2>Your Bookings</h2>

    <?php
    // Fetch bookings
    $booking_query = "SELECT * FROM bookings WHERE user_id = '$user_id'";
    $booking_result = $con->query($booking_query);
    while ($booking = $booking_result->fetch_assoc()) {
        echo "<p>Room: " . $booking['room_id'] . " - Price: रु " . $booking['total_price'] . "</p>";
        echo "<p>Check-in: " . $booking['check_in_date'] . " - Check-out: " . $booking['check_out_date'] . "</p>";
    }
    ?>

</body>
</html>
