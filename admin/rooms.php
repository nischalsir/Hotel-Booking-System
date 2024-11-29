<?php
require '../config/rooms.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Rooms</title>
    <style>
        .form-container {
            max-width: 500px;
        }
    </style>
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
                <li class="text-gray-600 mr-2 font-medium">Rooms</li>
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
        <h2 class="text-2xl font-bold mt-12 mb-6">Modify Room</h2>
<form method="POST">
    <div class="mb-4">
        <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
        <select id="room_type" name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            <option value="">Select Room Type</option>
            <?php
            // Fetch room types from the database
            $room_query = "SELECT DISTINCT room_type FROM rooms";
            $room_result = mysqli_query($conn, $room_query);

            if ($room_result && mysqli_num_rows($room_result) > 0) {
                while ($room_row = mysqli_fetch_assoc($room_result)) {
                    echo '<option value="' . htmlspecialchars($room_row['room_type']) . '">' . htmlspecialchars($room_row['room_type']) . '</option>';
                }
            } else {
                echo '<option value="">No rooms available</option>';
            }
            ?>
        </select>
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