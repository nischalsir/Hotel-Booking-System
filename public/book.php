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
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                    $headers .= "From: no-reply@hotelbooking.com" . "\r\n";

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Hotel Booking System</title>
    <style>
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
    <title>HBS - Rooms</title>
</head>
<body>
<nav class="navbar">
        <div class="logo">HBS</div>
        <ul class="nav-links">
            <li class="nav-link"><a href="index.php">Home</a></li>
            <li class="nav-link"><a href="book.php">Rooms</a></li>
            <li class="nav-link"><a href="facilities.php">Facilities</a></li>
            <li class="nav-link"><a href="contact.php">Contact</a></li>
            <li class="nav-link"><a href="about.php">About</a></li>

            <!-- User Info Section -->
            <?php if ($is_logged_in): ?>
                <li class="nav-link">
                    <img src="<?php echo htmlspecialchars($profile_pic_path); ?>" alt="Profile Picture" class="profile-pic" />
                </li>
                <li class="nav-link">
                    <a href="logout.php"><button class="btn">Logout</button></a>
                </li>
            <?php else: ?>
                <li class="nav-link">
                    <a href="login-user.php"><button class="btn">Sign In</button></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
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

            // Fetch available rooms
            $sql = "SELECT * FROM rooms WHERE available_rooms > 0";
            $roomsResult = $con->query($sql);

            if ($roomsResult->num_rows > 0) {
                // Display rooms based on availability
                while ($room = $roomsResult->fetch_assoc()) {
                    echo "
                        <div class='card'>
                            <img src='{$room['image']}' alt='{$room['room_type']}' class='room-image' />
                            <div class='card-content'>
                                <div class='card-header'>
                                    <h4>{$room['room_type']}</h4>
                                    <h4>रु {$room['price']}</h4>
                                </div>
                                <div class='features'>
                                    <span class='feature'>{$room['description']}</span>
                                </div>

                                <!-- Booking fields inside the card -->
                                <form action='' method='post' class='booking-form'>
                                    <input type='hidden' name='room_id' value='{$room['id']}' />

                                    <div>
                                        <label for='check_in_{$room['id']}' class='block mb-2 text-sm font-medium text-[#002D74]'>Check In</label>
                                        <input type='date' name='check_in' id='check_in_{$room['id']}' 
                                            class='bg-[#f1f1f1] border border-[#ddd] text-[#002D74] text-sm rounded-lg focus:ring-[#002D74] focus:border-[#002D74] block w-full p-2.5' 
                                            required />
                                    </div>
                                    <div>
                                        <label for='check_out_{$room['id']}' class='block mb-2 text-sm font-medium text-[#002D74]'>Check Out</label>
                                        <input type='date' name='check_out' id='check_out_{$room['id']}' 
                                            class='bg-[#f1f1f1] border border-[#ddd] text-[#002D74] text-sm rounded-lg focus:ring-[#002D74] focus:border-[#002D74] block w-full p-2.5' 
                                            required />
                                    </div>
                                    <div>
                                        <label for='guests_{$room['id']}' class='block mb-2 text-sm font-medium text-[#002D74]'>Guests</label>
                                        <input type='number' name='guests' id='guests_{$room['id']}' 
                                            class='bg-[#f1f1f1] border border-[#ddd] text-[#002D74] text-sm rounded-lg focus:ring-[#002D74] focus:border-[#002D74] block w-full p-2.5' 
                                            placeholder='Number of guests' required />
                                    </div>

                                    <button class='bg-[#002D74] rounded-xl text-white py-2 px-3 hover:scale-105 duration-300 mt-5' type='submit' name='book_now'>Book Now</button>
                                </form>
                            </div>
                        </div>
                    ";
                }
            } else {
                echo "<p>No rooms available.</p>";
            }
            ?>
        </div>
    
    </section>

    <?php include "include/footer.php"; ?>
</body>
</html>