<?php require '../config/dashboard.php'; ?>
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Bookings</title>
</head>

<body class="text-gray-800 font-inter">
    
    <!-- start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="../public/images/nischal.jpg" alt="" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3">HBS</span>
        </a>
        <ul class="mt-4">
    <li class="mb-1 group">
        <a href="admin-dashboard.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-home-2-line mr-3 text-lg"></i>
            <span class="text-sm">Dashboard</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="bookings.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-book-line mr-3 text-lg"></i>
            <span class="text-sm">Bookings</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="rooms.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-hotel-bed-line mr-3 text-lg"></i>
            <span class="text-sm">Rooms</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="reviews.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-star-line mr-3 text-lg"></i>
            <span class="text-sm">Reviews</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="messages.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-message-2-line mr-3 text-lg"></i>
            <span class="text-sm">Messages</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="admins.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-user-settings-line mr-3 text-lg"></i>
            <span class="text-sm">Admins</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="users.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-user-line mr-3 text-lg"></i>
            <span class="text-sm">Users</span>
        </a>
    </li>
    <li class="mb-1 group">
        <a href="checkout.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
            <i class="ri-cash-line mr-3 text-lg"></i>
            <span class="text-sm">Checkout</span>
        </a>
    </li>
</ul>
            </li>
            <li class="mb-1 group">
                <a href="logout-admin.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                    <i class="ri-logout-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
            <button type="button" class="text-lg text-gray-600 sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <ul class="flex items-center text-sm ml-4">
                <li class="mr-2">
                    <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Admin</a>
                </li>
                <li class="text-gray-600 mr-2 font-medium">/</li>
                <li class="text-gray-600 mr-2 font-medium">Bookings</li>
            </ul>
            <ul class="ml-auto flex items-center">
                
                <li class="dropdown ml-3">
    <button type="button" class="dropdown-toggle flex items-center">
        <span class="ml-2 font-medium text-gray-600"><?= htmlspecialchars($admin_name) ?></span>
        <img src="<?php echo htmlspecialchars($admin_image); ?>" alt="Admin Profile Picture" class="w-8 h-8 rounded object-cover block" />
    </button>
    <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
        <li>
            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
        </li>
        <li>
            <a href="logout-admin.php" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
        </li>
    </ul>
</li>
</ul>
</div>

<div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Bookings</h1>
        <table class="w-full min-w-[540px] border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Name</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Phone</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Room Name</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Guests</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Check-In</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Check-Out</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Status</th>
                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b border-gray-300">
                            <td class="py-2 px-4"><?= htmlspecialchars($row['user_name']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['user_phone']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['room_name']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['guests']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['check_in_date']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($row['check_out_date']) ?></td>
                            <td class="py-2 px-4">
                                <span class="inline-block p-1 rounded 
                                    <?= $row['status'] === 'Confirmed' ? 'bg-emerald-500/10 text-emerald-500' : 
                                        ($row['status'] === 'Cancelled' ? 'bg-red-500/10 text-red-500' : 'bg-yellow-500/10 text-yellow-500') ?> 
                                    font-medium text-[12px] leading-none">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td class="py-2 px-4">
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                    <input type="hidden" name="room_id" value="<?= $row['room_id'] ?>">
                                    <input type="hidden" name="user_email" value="<?= $row['user_email'] ?>">
                                    <input type="hidden" name="user_name" value="<?= $row['user_name'] ?>">
                                    <button type="submit" name="approve" class="text-blue-500 hover:underline">Approve</button>
                                </form>
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                    <input type="hidden" name="room_id" value="<?= $row['room_id'] ?>">
                                    <input type="hidden" name="user_email" value="<?= $row['user_email'] ?>">
                                    <input type="hidden" name="user_name" value="<?= $row['user_name'] ?>">
                                    <button type="submit" name="cancel" class="text-red-500 hover:underline">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">No bookings found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>