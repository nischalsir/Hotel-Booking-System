<?php
// Include the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 500px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-12 p-6 bg-white shadow-lg rounded-lg form-container">

        <!-- Add Room Form -->
        <h2 class="text-2xl font-bold mb-6">Add a New Room</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                <input type="text" id="room_type" name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                <select id="availability" name="availability" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Room Image</label>
                <input type="file" id="image" name="image" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" name="add_room" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">Add Room</button>
        </form>

        <!-- Modify Room Form -->
        <h2 class="text-2xl font-bold mt-12 mb-6">Modify Room</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                <input type="text" id="room_type" name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="new_price" class="block text-sm font-medium text-gray-700">New Price</label>
                <input type="number" id="new_price" name="new_price" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="new_availability" class="block text-sm font-medium text-gray-700">New Availability</label>
                <select id="new_availability" name="new_availability" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
            </div>

            <button type="submit" name="modify_room" class="w-full bg-yellow-600 text-white px-4 py-2 rounded-md">Modify Room</button>
        </form>

        <!-- Delete Room Form -->
        <h2 class="text-2xl font-bold mt-12 mb-6">Delete Room</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="delete_room_type" class="block text-sm font-medium text-gray-700">Room Type to Delete</label>
                <input type="text" id="delete_room_type" name="delete_room_type" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" name="delete_room" class="w-full bg-red-600 text-white px-4 py-2 rounded-md">Delete Room</button>
        </form>

        <!-- Rooms Table -->
        <h2 class="text-2xl font-bold mt-12 mb-6">Rooms</h2>
        <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Room Type</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Availability</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="px-4 py-2"><?php echo $row['room_type']; ?></td>
                    <td class="px-4 py-2"><?php echo $row['price']; ?></td>
                    <td class="px-4 py-2"><?php echo $row['availability'] == 1 ? 'Available' : 'Not Available'; ?></td>
                    <td class="px-4 py-2">
                        <form method="POST">
                            <button type="submit" name="delete_room" value="<?php echo $row['room_type']; ?>" class="bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
