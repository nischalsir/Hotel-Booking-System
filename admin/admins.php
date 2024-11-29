<?php require '../config/admins.php'; ?>
<?php require '../config/dashboard.php'; ?>
<?php 
// Fetch all admins from the database
$stmt = $con->prepare("SELECT first_name, last_name, email, phone, image_path FROM admin_cred");
$stmt->execute();
$result = $stmt->get_result();
$admins = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
    <title>Admins</title>
    
    <style>
        .slider-container {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding: 1rem 0;
            scroll-snap-type: x mandatory;
        }
        .card {
            flex: 0 0 auto;
            width: 300px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            scroll-snap-align: start;
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .card-content {
            padding: 1rem;
            text-align: center;
        }
        .card-content h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .card-content p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.25rem;
        }
        .delete-button {
    background-color: #FF4D4D;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 0.5rem 1rem;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.delete-button:hover {
    background-color: #FF1A1A;
}

    </style>
</head>

<body class="text-gray-800 font-inter">
    
    <!-- start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="../admin/img/hotel.png" alt="" class="w-8 h-8 rounded object-cover">
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
                <li class="text-gray-600 mr-2 font-medium">Admins</li>
            </ul>
            <ul class="ml-auto flex items-center">
                
                <li class="dropdown ml-3">
    <button type="button" class="dropdown-toggle flex items-center">
        <span class="ml-2 font-medium text-gray-600"><?= htmlspecialchars($admin_name) ?></span>
        <img src="<?= htmlspecialchars($admin_image) ?>" alt="Admin Profile Picture" class="w-8 h-8 rounded-full object-cover">
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
<h2>Admin List</h2>
        
        <!-- Slider for admin cards -->
        <div class="slider-container">
    <?php foreach ($admins as $admin): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($admin['image_path'] ?: 'uploads/default_profile_picture.png') ?>" alt="Profile Picture">
            <div class="card-content">
                <h3><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></h3>
                <p>Email: <?= htmlspecialchars($admin['email']) ?></p>
                <p>Phone: <?= htmlspecialchars($admin['phone']) ?></p>
                <form action="admins.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                    <input type="hidden" name="delete_email" value="<?= htmlspecialchars($admin['email']) ?>">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        
        <div class="max-w-2x2 mx-auto p-4">
            <H1>Add new admin</H1>
    <form action="admins.php" method="POST" enctype="multipart/form-data" class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">First Name</label>
                <input type="text" id="first_name" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="John" required>
            </div>
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Doe" required>
            </div>
            <div>
                <label for="address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">Address</label>
                <textarea id="address" name="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="123 Main St" required></textarea>
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">Phone Number</label>
                <input type="text" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="123-456-7890" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">Email Address</label>
                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="john.doe@example.com" required>
            </div>
            <div>
                <label for="image_path" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-900">Profile Picture</label>
                <input type="file" id="image_path" name="image_path" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
            </div>
        </div>
        <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800">Add Admin</button>
    </form>
</div>


    
    </main>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Optional: Add smooth scrolling behavior for the slider
        document.querySelector('.slider-container').style.scrollBehavior = 'smooth';
    </script>
</body>
</html>