<?php
// Include the database connection
include('../config/connection.php');

// Start session to access logged-in user data
session_start();

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>HBS - Rooms</title>
</head>
<body>
    <?php include('./include/header.php'); ?>

    <header class="header">
        <div class="header-img">
            <div class="header-content">
                <h1>Available Rooms</h1>
                <p>Choose a room and book your stay at the best price.</p>
            </div>
        </div>
    </header>

    <section class="section">
        <h2 class="section-title">Available Rooms</h2>
        <div class="grid">
            <?php
            if (!empty($message)) {
                echo "<div class='message'>$message</div>"; // Display message
            }
            if (!empty($availableRooms)) {
                // Display rooms based on availability
                foreach ($availableRooms as $room) {
                    echo "
                        <div class='card'>
                            <img src='{$room['image']}' alt='{$room['room_type']}' />
                            <div class='card-content'>
                                <div class='card-header'>
                                    <h4>{$room['room_type']}</h4>
                                    <h4>रु {$room['price']}</h4>
                                </div>
                                <div class='features'>
                                    <span class='feature'>{$room['description']}</span>
                                </div>
                            </div>
                        </div>
                    ";
                }
            } else {
                echo "<p>No rooms available.</p>";
            }
            ?>
        </div>

        <?php if (!empty($availableRooms)) { ?>
        <!-- Booking form -->
        <h2 class="form-title">Book Your Room</h2>
        
        <form method="POST" action="" class="mt-6">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Room</label>
                    <select name="room_id" id="room_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" disabled selected>Select a room</option>
                        <?php foreach ($availableRooms as $room) { ?>
                            <option value="<?php echo $room['id']; ?>"><?php echo $room['room_type']; ?> - रु <?php echo $room['price']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="check_in" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Check In</label>
                    <input type="date" name="check_in" id="check_in" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div>
                    <label for="check_out" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Check Out</label>
                    <input type="date" name="check_out" id="check_out" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div>
                    <label for="guests" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guests</label>
                    <input type="number" name="guests" id="guests" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Number of guests" required />
                </div>
            </div>
            <button type="submit" name="book_now" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Book Now</button>
        </form>
        </form>
        <?php } ?>
    </section>

    <?php include "include/footer.php"; ?>
</body>
</html>
