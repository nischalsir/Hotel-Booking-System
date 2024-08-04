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
    <title>HBS - Rooms</title>
  </head>
  <body>
    <nav>
      <div class="logo">HBS</div>
      <ul class="nav-links">
        <li class="nav-link"><a href="index.php">Home</a></li>
        <li class="nav-link"><a href="book.php">Rooms</a></li>
        <li class="nav-link"><a href="facilities.php">Facilities</a></li>
        <li class="nav-link"><a href="contact.php">Contact</a></li>
        <li class="nav-link"><a href="about.php">About</a></li>
        <a href="login-user.php"><button class="btn">Sign In</button></a>
      </ul>
    </nav>
    <header class="header">
  <div class="header-img">
    <div class="header-content">
      <h1>Check Availability</h1>
      <p>Book Hotels and stay packages at the lowest price.</p>
    </div>
    <div class="booking">
      <form>
        <div class="form-group">
          <select id="room-type" name="room-type" required>
            <option value="" disabled selected>Select your room type</option>
            <option value="deluxe-room">Deluxe Room</option>
            <option value="luxury-room">Luxury Room</option>
            <option value="suite-room">Suite Room</option>
            <option value="presidential-suite">Presidential Suite</option>
            <option value="executive-room">Executive Room</option>
            <option value="standard-room">Standard Room</option>
          </select>
          <p>Select your room type</p>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="date" required />
          </div>
          <p>Check In</p>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="date" required />
          </div>
          <p>Check Out</p>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="number" required />
          </div>
          <p>Add guests</p>
        </div>
      </form>
    </div>
  </div>
</header>

<section class="section">
  <h2 class="section-title">Popular Rooms</h2>
  <div class="grid">

    <div class="card">
      <img src="images/deluxe-room.jpeg" alt="Deluxe Room" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

    <div class="card">
      <img src="images/luxury-room.jpeg" alt="Luxury Room" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

    <div class="card">
      <img src="images/suite-room.jpeg" alt="Suite Room" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

    <div class="card">
      <img src="images/presidential-suite.jpeg" alt="Presidential Suite" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

    <div class="card">
      <img src="images/executive-room.jpeg" alt="Executive Room" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

    <div class="card">
      <img src="images/standard-room.jpeg" alt="Standard Room" />
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
        <a href="rooms.php" class="btn book-now">Book Now</a>
      </div>
    </div>

  </div>
</section>


    <footer class="footer">
      <div class="section">
        <div class="footer-col">
          <h3>HBS</h3>
          <p>
            HBS is a premier hotel booking website that offers a seamless and
            convenient way to find and book accommodations worldwide.
          </p>
          <p>
            With a user-friendly interface and a vast selection of hotels,
            HBS aims to provide a stress-free experience for travelers
            seeking the perfect stay.
          </p>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <p>About Us</p>
          <p>Our Team</p>
          <p>Blog</p>
          <p>Book</p>
          <p>Contact Us</p>
        </div>
        <div class="footer-col">
          <h4>Legal</h4>
          <p>FAQs</p>
          <p>Terms & Conditions</p>
          <p>Privacy Policy</p>
        </div>
        <div class="footer-col">
          <h4>Resources</h4>
          <p>Social Media</p>
          <p>Help Center</p>
          <p>Partnerships</p>
        </div>
      </div>
      <div class="footer-bar">
        Copyright © 2023 Hotel Booking System. All rights reserved.
      </div>
    </footer>
  </body>
</html>
