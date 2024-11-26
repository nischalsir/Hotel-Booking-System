<?php include("../config/booking.php")?>
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