<?php require '../config/dashboard.php'; ?>
<?php require '../config/checkout.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CheckOut</title>
</head>

< class="text-gray-800 font-inter">
    
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
                <li class="text-gray-600 mr-2 font-medium">Checkout</li>
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

<div class="container mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-6">Checkout</h1>

            <!-- Search Input -->
            <div class="mb-4">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="border border-gray-300 rounded px-4 py-2 w-full" 
                    placeholder="Search by name or phone..."
                    onkeyup="filterTable()">
            </div>

            <!-- Bookings Table -->
            <table id="bookingsTable" class="w-full border border-gray-300 rounded mb-6">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Phone</th>
                        <th class="py-2 px-4 text-left">Room</th>
                        <th class="py-2 px-4 text-left">Guests</th>
                        <th class="py-2 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="border-t">
                                <td class="py-2 px-4"><?= htmlspecialchars($row['user_name']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['user_phone']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['room_name']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($row['guests']) ?></td>
                                <td class="py-2 px-4">
                                    <button 
                                        onclick="populateCheckoutForm(
                                            <?= $row['booking_id'] ?>,
                                            <?= $row['room_price'] ?>,
                                            <?= $row['guests'] ?>,
                                            '<?= htmlspecialchars($row['user_name']) ?>',
                                            '<?= htmlspecialchars($row['user_phone']) ?>',
                                            '<?= htmlspecialchars($row['room_name']) ?>',
                                            '<?= htmlspecialchars($row['user_email']) ?>'
                                        )"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Checkout
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-4 text-center">No bookings found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Checkout Form -->
            <div id="checkoutForm" class="border border-gray-300 rounded p-6 bg-white shadow hidden">
                <h2 class="text-xl font-bold mb-4">Checkout Form</h2>
                <form method="POST" action="">
                    <input type="hidden" name="booking_id" id="bookingId">
                    <input type="hidden" name="user_email" id="userEmail">
                    <input type="hidden" name="payment_method" id="paymentMethod">

                    <div class="mb-4">
                        <label for="userName" class="block text-sm font-medium mb-2">Customer Name</label>
                        <input type="text" id="userName" class="border border-gray-300 rounded px-4 py-2 w-full" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="userPhone" class="block text-sm font-medium mb-2">Customer Phone</label>
                        <input type="text" id="userPhone" class="border border-gray-300 rounded px-4 py-2 w-full" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="roomName" class="block text-sm font-medium mb-2">Room</label>
                        <input type="text" id="roomName" class="border border-gray-300 rounded px-4 py-2 w-full" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="guests" class="block text-sm font-medium mb-2">Number of Guests</label>
                        <input type="text" id="guests" class="border border-gray-300 rounded px-4 py-2 w-full" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="amountPaid" class="block text-sm font-medium mb-2">Amount Paid</label>
                        <input type="number" id="amountPaid" name="amount_paid" class="border border-gray-300 rounded px-4 py-2 w-full" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="discountCode" class="block text-sm font-medium mb-2">Discount Code</label>
                        <input type="text" id="discountCode" name="discount_code" class="border border-gray-300 rounded px-4 py-2 w-full">
                    </div>

                    <!-- Payment Method Buttons -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Payment Method</label>
                        <div class="flex space-x-4">
                            <button type="button" onclick="setPaymentMethod('Cash')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" id="cashButton">Cash</button>
                            <button type="button" onclick="setPaymentMethod('Online')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" id="onlineButton">Online</button>
                        </div>
                    </div>

                    <button type="submit" name="checkout" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Submit Checkout</button>
                </form>
            </div>
        </div>
    </main>

    <!-- QR Code Modal -->
    <div id="qrCodeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-md text-center">
            <h3 class="text-lg font-semibold mb-4">Scan QR Code for Payment</h3>
            <img src="./img/eSewa_My_QR_9865060952_1732871818812.jpg" alt="QR Code" class="w-60 h-50 mx-auto mb-4">
            <p class="text-gray-600">Please scan the code with your payment app.</p>
        </div>
    </div>

    <script>
        // Filter table based on search input
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('bookingsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip table header
                const cells = rows[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length - 1; j++) { // Ignore the last column (Action)
                    if (cells[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? '' : 'none';
            }
        }

        // Populate checkout form
        function populateCheckoutForm(bookingId, roomPrice, guests, userName, userPhone, roomName, userEmail) {
            document.getElementById('checkoutForm').classList.remove('hidden');
            document.getElementById('bookingId').value = bookingId;
            document.getElementById('userEmail').value = userEmail;
            document.getElementById('userName').value = userName;
            document.getElementById('userPhone').value = userPhone;
            document.getElementById('roomName').value = roomName;
            document.getElementById('guests').value = guests;

            // Calculate total amount and populate the Amount Paid field
            const totalAmount = roomPrice * guests;
            document.getElementById('amountPaid').value = totalAmount.toFixed(2); // Fixed to 2 decimal places
        }

        // Set payment method, show QR code if "Online" is selected
        function setPaymentMethod(method) {
            document.getElementById('paymentMethod').value = method;

            const cashButton = document.getElementById('cashButton');
            const onlineButton = document.getElementById('onlineButton');
            const qrModal = document.getElementById('qrCodeModal');

            // Highlight the selected button
            if (method === 'Cash') {
                cashButton.classList.add('bg-green-500');
                cashButton.classList.remove('bg-gray-500');
                onlineButton.classList.add('bg-gray-500');
                onlineButton.classList.remove('bg-green-500');
            } else if (method === 'Online') {
                onlineButton.classList.add('bg-green-500');
                onlineButton.classList.remove('bg-gray-500');
                cashButton.classList.add('bg-gray-500');
                cashButton.classList.remove('bg-green-500');

                // Show the QR code modal for 5 seconds
                qrModal.classList.remove('hidden');
                setTimeout(() => {
                    qrModal.classList.add('hidden');
                }, 5000);
            }
        }
    </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>