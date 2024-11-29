<?php
// Include the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

session_start();

// Define the timeout duration (in seconds)
define('INACTIVITY_TIMEOUT', 300); // 300 seconds = 5 minutes

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Admin is not logged in, redirect to index.php
    header("Location: index.php");
    exit();
}

// Check for session timeout due to inactivity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > INACTIVITY_TIMEOUT) {
    // Last activity was more than the timeout duration ago
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: index.php?timeout=true"); // Redirect with a timeout message
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Default profile picture
$default_admin_pic = '../public/images/default-profile.png';

// Initialize admin profile data
$admin_id = $_SESSION['admin_id'] ?? null;
$admin_name = 'Admin';
$admin_image = $default_admin_pic;

// Fetch admin details if logged in
if ($admin_id) {
    $stmt = $conn->prepare("SELECT first_name, image_path FROM admin_cred WHERE sr_no = ?");
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
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add room functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_room'])) {
    // Get form data
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];

    // Define the target directory for images
    $target_dir = "images/";
    $image_name = basename($_FILES['image']['name']); // Use the original file name
    $image_path = $target_dir . $image_name; // Path to save in the database

    // Ensure the images directory exists
    if (!is_dir("../images")) {
        mkdir("../images", 0755, true); // Create directory if it doesn't exist
    }

    // Check for duplicate file names and handle them
    if (file_exists("../" . $image_path)) {
        echo "Error: A file with the same name already exists. Please rename your file and try again.";
        exit;
    }

    // Move the uploaded image to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../" . $image_path)) {
        // Insert room data into the database
        $query = "INSERT INTO rooms (room_type, description, price, availability, image) 
                  VALUES ('$room_type', '$description', '$price', '$availability', '$image_path')";

        if (mysqli_query($conn, $query)) {
            echo "Room added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}

// Modify room functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modify_room'])) {
    $room_type = $_POST['room_type'];
    $new_price = $_POST['new_price'];
    $new_availability = $_POST['new_availability'];

    // Check if the room type exists in the database
    $check_query = "SELECT * FROM rooms WHERE room_type = '$room_type'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Room type exists, proceed with the update
        $update_query = "UPDATE rooms SET price = '$new_price', availability = '$new_availability' WHERE room_type = '$room_type'";

        if (mysqli_query($conn, $update_query)) {
            $notification = "Room details updated successfully!";
            $notification_type = "success";  // For success
        } else {
            $notification = "Error updating room details: " . mysqli_error($conn);
            $notification_type = "error";  // For error
        }
    } else {
        // Room type doesn't exist
        $notification = "Room type not found!";
        $notification_type = "error";  // For error
    }
}

// Delete room functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_room'])) {
    $room_type = $_POST['delete_room'];

    // Delete the room from the database based on room type
    $query = "DELETE FROM rooms WHERE room_type = '$room_type'";

    if (mysqli_query($conn, $query)) {
        echo "Room deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch all rooms for display
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);
?>
<?php if (isset($notification)): ?>
    <div class="notification <?php echo $notification_type; ?> p-4 mb-4">
        <p><?php echo $notification; ?></p>
    </div>
<?php endif; ?>