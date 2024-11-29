<?php include('../config/profile.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to preview image before uploading
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <style>
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        #star-rating .bx {
            transition: color 0.2s ease, transform 0.2s ease;
        }
        #star-rating .bx:hover {
            transform: scale(1.2);
            color: #ffc107;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">HBS</div>
        <ul class="nav-links">
            <li class="nav-link"><a href="index.php">Home</a></li>
            <li class="nav-link"><a href="book.php">Rooms</a></li>
            <li class="nav-link"><a href="facilities.php">Facilities</a></li>
            <li class="nav-link"><a href="contact.php">Contact</a></li>
            <li class="nav-link"><a href="about.php">About</a></li>
            <?php if ($is_logged_in): ?>
                <li class="nav-link">
                    <a href="profile.php">
                        <img src="<?php echo htmlspecialchars($profile_pic_path); ?>" alt="Profile Picture" class="profile-pic" />
                    </a>
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

    <section class="bg-gray-50 min-h-screen flex items-center w-full justify-center">
    <div class="bg-gray-100 rounded-2xl shadow-lg max-w-6xl w-full p-8 space-y-8">
        <!-- Row 1: Profile Management and Bookings -->
        <div class="flex flex-wrap md:flex-nowrap gap-6">
            <!-- Profile Management Card -->
            <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/2">
                <h2 class="font-bold text-2xl text-[#002D74] text-center">User Profile</h2>
                <p class="text-xs mt-4 text-[#002D74] text-center">Manage your profile information.</p>
                <form action="profile.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="flex flex-col gap-6">
                    <div class="flex items-center gap-4">
                        <div class="col-span-full">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                            <div class="mt-2 flex items-center gap-x-3">
                                <img id="imagePreview" class="h-12 w-12 rounded-full object-cover border border-gray-300" alt="profile picture" src="<?php echo $profile_pic_path; ?>">
                                <label class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Upload
                                    <input type="file" name="profile_picture" id="profile_picture" class="hidden" onchange="previewImage(event)" required>
                                </label>
                            </div>
                        </div>
                    </div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input class="p-3 rounded-xl border" type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input class="p-3 rounded-xl border" type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>

                    <button type="submit" name="update_profile" class="bg-blue-500 text-white py-2 rounded-lg">Update Profile</button>
                </form>
            </div>

            <!-- Bookings Card (Scrollable) -->
            <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/2">
                <h3 class="font-bold text-xl">Your Bookings</h3>
                <div class="mt-4 overflow-y-scroll max-h-64">
                    <?php if ($bookings->num_rows > 0): ?>
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Room ID</th>
                                    <th class="px-4 py-2 text-left">Check-in Date</th>
                                    <th class="px-4 py-2 text-left">Check-out Date</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($booking = $bookings->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-4 py-2"><?php echo $booking['room_id']; ?></td>
                                        <td class="px-4 py-2"><?php echo $booking['check_in_date']; ?></td>
                                        <td class="px-4 py-2"><?php echo $booking['check_out_date']; ?></td>
                                        <td class="px-4 py-2"><?php echo $booking['status']; ?></td>
                                        <td class="px-4 py-2">
                                            <form action="profile.php" method="POST">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                <button type="submit" name="cancel_booking" class="text-red-500">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No bookings found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Row 2: Review Submission and Reviews List -->
        <div class="flex flex-wrap md:flex-nowrap gap-6">
            <!-- Review Submission Card -->
            <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/2">
                <h3 class="font-bold text-xl">Submit a Review</h3>
                <p class="text-sm text-gray-500">We value your feedback! Leave a review with a star rating.</p>
                <form action="profile.php" method="POST" class="flex flex-col gap-4 mt-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <div id="star-rating" class="flex gap-1 text-yellow-500 text-2xl">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bx bx-star cursor-pointer" data-value="<?php echo $i; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required>

                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                    <textarea name="comment" id="comment" rows="3" class="p-3 rounded-lg border" placeholder="Write your review here..."></textarea>

                    <button type="submit" name="submit_review" class="bg-blue-500 text-white py-2 rounded-lg">Submit Review</button>
                </form>
            </div>

            <!-- Reviews List Card (Scrollable) -->
            <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/2">
                <h3 class="font-bold text-xl">Your Reviews</h3>
                <div class="mt-4 overflow-y-scroll max-h-64">
                    <?php if ($user_reviews->num_rows > 0): ?>
                        <div class="space-y-4">
                            <?php while ($review = $user_reviews->fetch_assoc()): ?>
                                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">
                                                Rating: <?php echo $review['rating']; ?> / 5
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo date('F j, Y, g:i a', strtotime($review['created_at'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-gray-800"><?php echo htmlspecialchars($review['comment']); ?></p>
                                    <form action="profile.php" method="POST" class="mt-4">
                                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                        <button type="submit" name="delete_review" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">You haven't submitted any reviews yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


    <script>
        const stars = document.querySelectorAll('#star-rating .bx');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                ratingInput.value = star.getAttribute('data-value');
                stars.forEach(s => s.classList.replace('bxs-star', 'bx-star'));
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.replace('bx-star', 'bxs-star');
                }
            });
        });
    </script>
</body>
</html>
