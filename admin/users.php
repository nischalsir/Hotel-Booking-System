<?php require '../config/dashboard.php'; ?>
<?php
// Fetch users from the database
$search_query = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    $stmt = $con->prepare("SELECT id, name, email, phone FROM usertable WHERE name LIKE ?");
    $search_term = '%' . $search_query . '%';
    $stmt->bind_param("s", $search_term);
} else {
    $stmt = $con->prepare("SELECT id, name, email, phone FROM usertable");
}
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_stmt = $con->prepare("DELETE FROM usertable WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        header("Location: dashboard.php?deleted=true");
        exit;
    }
    $delete_stmt->close();
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
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
    <title>Users</title>
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
                <li class="text-gray-600 mr-2 font-medium">Users</li>
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
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
<div class="p-4">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="Search by name..." 
        class="w-full p-2 border border-gray-300 rounded-lg"
        onkeyup="filterTable()"
    >
</div>
    <table class="w-full text-sm text-left text-gray-500 bg-white">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Phone</th>
                <th scope="col" class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr class="bg-white border-b hover:bg-gray-50">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    <?= htmlspecialchars($user['name']) ?>
                </th>
                <td class="px-6 py-4"><?= htmlspecialchars($user['email']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($user['phone']) ?></td>
                <td class="px-6 py-4 text-right">
                    <form action="dashboard.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($user['id']) ?>">
                        <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.querySelector("table tbody");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByTagName("th")[0]; // Assuming name is in the first column
        if (nameCell) {
            const nameText = nameCell.textContent || nameCell.innerText;
            rows[i].style.display = nameText.toLowerCase().includes(filter) ? "" : "none";
        }
    }
}
</script>
</main>
<script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>