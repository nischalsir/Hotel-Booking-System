<?php
  // Connect to the database
  $conn = mysqli_connect('localhost', 'root', '', 'hotel_booking'); // Ensure this is set up with your DB credentials

  // Fetch reviews with user details (including profile picture)
  $query = "SELECT reviews.*, usertable.profile_picture FROM reviews 
            JOIN usertable ON reviews.user_email = usertable.email 
            ORDER BY reviews.created_at DESC"; // You can order by created_at to show the most recent first
  $result = mysqli_query($conn, $query);

  // Check if there are any reviews
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Hotel Booking System</title>
  </head>
  <body>
    <?php include('./include/header.php'); ?>
    <header class="header">
      <div class="header-img">
        <div class="header-content">
          <h1>Enjoy Your Dream Vacation</h1>
          <p>Book Hotels and stay packages at the lowest price.</p>
        </div>
      </div>
    </header>

    <section class="section">
      <h2 class="section-title">Popular Rooms</h2>
      <div class="grid">

        <a href="book.php" class="card">
          <img src="images/deluxe-room.jpeg" alt="popular room" />
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
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bx-star' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

        <a href="book.php" class="card">
          <img src="images/luxury-room.jpeg" alt="popular room" />
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
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

        <a href="book.php" class="card">
          <img src="images/suite-room.jpeg" alt="popular room" />
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
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star-half' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

        <a href="book.php" class="card">
          <img src="images/presidential-suite.jpeg" alt="popular room" />
          <div class="card-content">
            <div class="card-header">
              <h4>Presidential Suite</h4>
              <h4>रु 12,000</h4>
            </div>
            <div class="features">
              <span class="feature">3 Beds</span>
              <span class="feature">Free Wi-Fi</span>
              <span class="feature">Swimming Pool</span>
              <span class="feature">Private Balcony</span>
            </div>
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

        <a href="book.php" class="card">
          <img src="images/executive-room.jpeg" alt="popular room" />
          <div class="card-content">
            <div class="card-header">
              <h4>Executive Room</h4>
              <h4>रु 8,000</h4>
            </div>
            <div class="features">
              <span class="feature">1 King Bed</span>
              <span class="feature">Free Wi-Fi</span>
              <span class="feature">Executive Desk</span>
            </div>
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bx-star' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

        <a href="book.php" class="card">
          <img src="images/standard-room.jpeg" alt="popular room" />
          <div class="card-content">
            <div class="card-header">
              <h4>Standard Room</h4>
              <h4>रु 4,000</h4>
            </div>
            <div class="features">
              <span class="feature">1 Bed</span>
              <span class="feature">Free Wi-Fi</span>
              <span class="feature">Basic Amenities</span>
            </div>
            <div class="feature">
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star' style='color:#ffe200'></i>
              <i class='bx bxs-star-half' style='color:#ffe200'></i>
              <i class='bx bx-star' style='color:#ffe200'></i>
            </div>
          </div>
        </a>

      </div>
    </section>

    <section class="section client">
      <div class="section">
        <h2 class="section-title">What our clients say</h2>
        <div class="grid">
          <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
              <div class="client-card">
                <!-- Display user's profile picture -->
                <?php if (!empty($review['profile_picture'])): ?>
                  <img src="uploads/<?= htmlspecialchars($review['profile_picture']); ?>" alt="client" class="client-profile-picture" />
                <?php else: ?>
                  <img src="uploads/default-profile.jpg" alt="client" class="client-profile-picture" /> <!-- Fallback if no profile picture -->
                <?php endif; ?>
                <p>
                  <?= htmlspecialchars($review['comment']); ?>
                </p>
                <div class="rating">
                  <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                    <i class='bx bxs-star' style='color:#ffe200'></i>
                  <?php endfor; ?>
                  <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                    <i class='bx bx-star' style='color:#ffe200'></i>
                  <?php endfor; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No reviews yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

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
