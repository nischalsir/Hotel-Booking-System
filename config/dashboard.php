<?php
require '../config/connection.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Admin is not logged in, redirect to index.php
    header("Location: index.php");
    exit();
}

// Default profile picture
$default_admin_pic = '../public/images/default-profile.png';

// Initialize admin profile data
$admin_id = $_SESSION['admin_id'] ?? null;
$admin_name = 'Admin';
$admin_image = $default_admin_pic;

// Fetch admin details if logged in
if ($admin_id) {
    $stmt = $con->prepare("SELECT first_name, image_path FROM admin_cred WHERE sr_no = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $admin_data = $result->fetch_assoc();
        $admin_name = $admin_data['first_name'] ?? 'Admin';
        $admin_image = !empty($admin_data['image_path']) ? $admin_data['image_path'] : $default_admin_pic;
    }
    $stmt->close();
}

// Fetch total rooms and availability
$stmt = $con->prepare("SELECT SUM(available_rooms) AS total_rooms, COUNT(*) AS all_rooms FROM rooms");
$stmt->execute();
$result = $stmt->get_result();
$room_data = $result->fetch_assoc();
$total_rooms = $room_data['total_rooms'] ?? 0;
$all_rooms = $room_data['all_rooms'] ?? 0;
$stmt->close();

$total_rooms_fixed = 60; 
$room_availability_percentage = $total_rooms_fixed > 0 ? round(($total_rooms / $total_rooms_fixed) * 100) : 0;

// Fetch total bookings
$stmt = $con->prepare("SELECT COUNT(*) AS total_bookings FROM bookings");
$stmt->execute();
$result = $stmt->get_result();
$total_bookings = $result->fetch_assoc()['total_bookings'] ?? 0;
$stmt->close();

// Fetch total guests today
$stmt = $con->prepare("SELECT SUM(guests) AS total_guests FROM bookings WHERE check_in_date = CURDATE()");
$stmt->execute();
$result = $stmt->get_result();
$total_guests = $result->fetch_assoc()['total_guests'] ?? 0;
$stmt->close();

// Fetch total revenue from the checkouts table
$stmt = $con->prepare("
    SELECT SUM(amount_paid) AS total_revenue 
    FROM checkouts
");
$stmt->execute();
$result = $stmt->get_result();
$total_revenue = $result->fetch_assoc()['total_revenue'] ?? 0.00;
$stmt->close();

// Fetch total and new users
$stmt = $con->prepare("SELECT COUNT(*) AS total_users, SUM(created_at >= NOW() - INTERVAL 1 DAY) AS new_users FROM usertable");
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$total_users = $user_data['total_users'] ?? 0;
$new_users = $user_data['new_users'] ?? 0;
$stmt->close();

// Fetch bookings by status
function fetch_bookings($con, $status) {
    $stmt = $con->prepare("
        SELECT b.id, u.name AS user_name, b.check_in_date, b.check_out_date, b.status, b.guests 
        FROM bookings b
        JOIN usertable u ON b.user_email = u.email
        WHERE b.status = ?
    ");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $bookings;
}

$active_bookings = fetch_bookings($con, 'Pending');
$completed_bookings = fetch_bookings($con, 'Confirmed');
$canceled_bookings = fetch_bookings($con, 'Cancelled');

// Fetch booking counts for chart
function get_booking_counts($con, $status) {
    $data = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $stmt = $con->prepare("SELECT COUNT(*) as count FROM bookings WHERE status = ? AND DATE(booking_date) = ?");
        $stmt->bind_param("ss", $status, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $data[] = $result->fetch_assoc()['count'] ?? 0;
        $stmt->close();
    }
    return $data;
}

$active_data = get_booking_counts($con, 'Pending');
$completed_data = get_booking_counts($con, 'Confirmed');
$canceled_data = get_booking_counts($con, 'Cancelled');
?>
<?php
// Fetch earnings per user
$stmt = $con->prepare("
    SELECT u.name AS user_name, SUM(b.guests * r.price) AS total_earning
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    JOIN usertable u ON b.user_email = u.email
    WHERE b.status = 'Confirmed'
    GROUP BY u.name
    ORDER BY total_earning DESC
    LIMIT 10
");

$stmt->execute();
$result = $stmt->get_result();
$earnings_data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<?php
$labels = [];
for ($i = 6; $i >= 0; $i--) {
    $labels[] = date('M j', strtotime("-$i days"));
}
?>