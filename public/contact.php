<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>HWIC - Contact Us</title>
</head>
<body>
  <nav>
    <div class="logo">HBS</div>
    <ul class="nav-links">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="#">Rooms</a></li>
      <li class="nav-link"><a href="facilities.php">Facilities</a></li>
      <li class="nav-link"><a href="contact.php">Contact</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
      <a href="login-user.php"><button class="btn">Sign In</button></a>
    </ul>
  </nav>

  <header class="header">
    <div class="header-img">
      <div class="header-content">
        <h1>Contact Us</h1>
        <p>Get in touch with us for any inquiries or feedback.</p>
      </div>
    </div>
  </header>

  <section class="section contact">
    <div class="contact-info">
      <div class="contact-details">
        <h2 class="section-title">Contact Information</h2>
        <ul>
          <li><i class="ri-map-pin-line"></i> 123 Hotel Street, City, Country</li>
          <li><i class="ri-phone-line"></i> +1 (123) 456-7890</li>
          <li><i class="ri-mail-line"></i> info@hwic.com</li>
        </ul>
      </div>
      <div class="contact-form">
        <h2 class="section-title">Send Us a Message</h2>
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn">Send Message</button>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="section">
      <div class="footer-col">
        <h3>WDM&Co</h3>
        <p>
          WDM&Co is a premier hotel booking website that offers a seamless and
          convenient way to find and book accommodations worldwide.
        </p>
        <p>
          With a user-friendly interface and a vast selection of hotels,
          WDM&Co aims to provide a stress-free experience for travelers
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
      Copyright © 2023 Web Design Mastery. All rights reserved.
    </div>
  </footer>
</body>
</html>
