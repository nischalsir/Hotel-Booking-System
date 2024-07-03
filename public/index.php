<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>HWIC</title>
  </head>
  <body>
    <nav>
      <div class="logo">Bharatpur Terminal In</div>
      <ul class="nav-links">
        <li class="nav-link"><a href="#">Home</a></li>
        <li class="nav-link"><a href="#">Rooms</a></li>
        <li class="nav-link"><a href="#">Facilities</a></li>
        <li class="nav-link"><a href="#">Contact</a></li>
        <li class="nav-link"><a href="#">About</a></li>
        <button class="btn"><a href="login-user.php">Sign In</a></button>
      </ul>
    </nav>
    <header class="header">
      <div class="header-img">
        <div class="header-content">
          <h1>Enjoy Your Dream Vacation</h1>
          <p>Book Hotels and stay packages at lowest price.</p>
        </div>
        <div class="booking">
          <form>
            <div class="form-group">
              <div class="input-group">
                <input type="text" required />
                <label>Location</label>
              </div>
              <p>Where are you going?</p>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="date" required />
                <label>Check In</label>
              </div>
              <p>Add date</p>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="date" required />
                <label>Check Out</label>
              </div>
              <p>Add date</p>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="number" required />
                <label>Guests</label>
              </div>
              <p>Add guests</p>
            </div>
          </form>
          <button class="btn"><i class="ri-search-line"></i></button>
        </div>        
      </div>
    </header>

    <section class="section">
      <h2 class="section-title">Popular Hotels</h2>
      <div class="grid">
        <div class="card">
          <img src="assets/hotel-1.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>The Plaza Hotel</h4>
              <h4>$499</h4>
            </div>
            <p>New York City, USA</p>
          </div>
        </div>
        <div class="card">
          <img src="assets/hotel-2.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>Ritz Paris</h4>
              <h4>$549</h4>
            </div>
            <p>Paris, France</p>
          </div>
        </div>
        <div class="card">
          <img src="assets/hotel-3.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>The Peninsula</h4>
              <h4>$599</h4>
            </div>
            <p>Hong Kong</p>
          </div>
        </div>
        <div class="card">
          <img src="assets/hotel-4.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>Atlantis The Palm</h4>
              <h4>$449</h4>
            </div>
            <p>Dubai, United Arab Emirates</p>
          </div>
        </div>
        <div class="card">
          <img src="assets/hotel-5.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>The Ritz-Carlton</h4>
              <h4>$649</h4>
            </div>
            <p>Tokyo, Japan</p>
          </div>
        </div>
        <div class="card">
          <img src="assets/hotel-6.jpg" alt="popular hotel" />
          <div class="card-content">
            <div class="card-header">
              <h4>Marina Bay Sands</h4>
              <h4>$549</h4>
            </div>
            <p>Singapore</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section client">
      <div class="section">
        <h2 class="section-title">What our clients say</h2>
        <div class="grid">
          <div class="client-card">
            <img src="assets/client-1.jpg" alt="client" />
            <p>
              The booking process was seamless, and the confirmation was
              instant. I highly recommend WDM&Co for hassle-free hotel bookings.
            </p>
          </div>
          <div class="client-card">
            <img src="assets/client-2.jpg" alt="client" />
            <p>
              The website provided detailed information about hotels, including
              amenities and photos, which helped me make an informed decision.
            </p>
          </div>
          <div class="client-card">
            <img src="assets/client-3.jpg" alt="client" />
            <p>
              I was able to book a room within minutes, and the hotel exceeded
              my expectations. I appreciate WDM&Co's efficiency and reliability.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="section reward">
      <div class="reward-content">
        <p>100+ discount codes</p>
        <h4>Register and discover amazing discounts on your booking.</h4>
        <button class="btn">Register</button>
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
