<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>HBS - SignUp</title>
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
      </ul>
    </nav>
    <header class="header">
      <div class="header-img">
        <div class="header-content">
          <h1>Sign Up</h1>
          <p>Book Hotels and stay packages at lowest price.</p>
        </div>
        <div class="booking">
        <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
              <form action="signup-user.php" method="POST" autocomplete="">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="name" required />
                        <label>Name</label>
                    </div>
                    <p>Please enter your name</p>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" name="email" required />
                        <label>Email</label>
                    </div>
                    <p>Enter your email</p>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="number" name="phone" required />
                        <label>Phone</label>
                    </div>
                    <p>Enter your contact number</p>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="password" required />
                        <label>Password</label>
                    </div>
                    <p>Enter password</p>
                </div>
                <button class="btn" type="submit" name="signup">Sign Up</button>
            </form>
          <p>Already have an account? <a href="login-user.php">Login</a></p>
        </div>        
      </div>
    </header>

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