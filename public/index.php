<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'hotel_booking');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch reviews with user details
$query = "SELECT reviews.*, usertable.name, usertable.profile_picture 
          FROM reviews 
          JOIN usertable ON reviews.user_email = usertable.email 
          ORDER BY reviews.created_at DESC";
$result = mysqli_query($conn, $query);

// Collect reviews into an array
$reviews = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>

    <!-- External CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/index.css">

    <!-- Swiper.js Script -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>
    <?php include('./include/header.php'); ?>

    <!-- Header Section -->
    <header class="header">
        <div class="header-img">
            <div class="header-content">
                <h1>Enjoy Your Dream Vacation</h1>
                <p>Book Hotels and stay packages at the lowest price.</p>
            </div>
        </div>
    </header>

    <!-- Popular Rooms Section -->
    <section class="section">
        <h2 class="section-title">Popular Rooms</h2>
        <div class="grid">
            <a href="book.php" class="card">
                <img src="images/deluxe-room.jpeg" alt="Deluxe Room">
                <div class="card-content">
                    <div class="card-header">
                        <h4>Deluxe Room</h4>
                        <h4>रु 2,500</h4>
                    </div>
                    <div class="features">
                        <span class="feature">2 Beds</span>
                        <span class="feature">Free Wi-Fi</span>
                        <span class="feature">Breakfast Included</span>
                    </div>
                </div>
            </a>

            <a href="book.php" class="card">
                <img src="images/luxury-room.jpeg" alt="Luxury Room">
                <div class="card-content">
                    <div class="card-header">
                        <h4>Luxury Room</h4>
                        <h4>रु 6,000</h4>
                    </div>
                    <div class="features">
                        <span class="feature">1 King Bed</span>
                        <span class="feature">Free Wi-Fi</span>
                        <span class="feature">Mini Bar</span>
                    </div>
                </div>
            </a>

            <a href="book.php" class="card">
                <img src="images/suite-room.jpeg" alt="Suite Room">
                <div class="card-content">
                    <div class="card-header">
                        <h4>Suite Room</h4>
                        <h4>रु 7,500</h4>
                    </div>
                    <div class="features">
                        <span class="feature">2 Beds</span>
                        <span class="feature">Free Wi-Fi</span>
                        <span class="feature">Living Area</span>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Client Reviews Section -->
    <section class="section client">
        <h2 class="section-title">What Our Clients Say</h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="swiper-slide client-card">
                            <div class="client-info">
                                <?php
                                $profilePic = $review['profile_picture'] ?: 'images/default-avatar.png';
                                ?>
                                <img src="<?= htmlspecialchars($profilePic); ?>" alt="Client Avatar" class="client-avatar">
                                <h4 class="client-name"><?= htmlspecialchars($review['name']); ?></h4>
                            </div>
                            <p class="client-comment"><?= htmlspecialchars($review['comment']); ?></p>
                            <div class="rating">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                    <i class="bx bxs-star" style="color:#ffe200"></i>
                                <?php endfor; ?>
                                <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                    <i class="bx bx-star" style="color:#ffe200"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Swiper Styles -->
    <style>
        .swiper-container {
            width: 100%;
            padding: 2rem 0;
        }
        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        .client-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        .client-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .client-comment {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .rating {
            display: flex;
            justify-content: center;
        }
    </style>

    <!-- Swiper Initialization -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    </script>

    <!-- Rewards Section -->
    <section class="section reward">
        <div class="reward-content">
            <p>100+ discount codes</p>
            <h4>Register and discover amazing discounts on your booking.</h4>
            <a href="signup-user.php"><button class="btn">Register</button></a>
        </div>
    </section>

    <?php include('./include/footer.php'); ?>
</body>
</html>