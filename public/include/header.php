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
    <nav>
      <div class="logo">HBS</div>
      <ul class="nav-links">
        <li class="nav-link"><a href="index.php">Home</a></li>
        <li class="nav-link"><a href="book.php">Rooms</a></li>
        <li class="nav-link"><a href="facilities.php">Facilities</a></li>
        <li class="nav-link"><a href="contact.php">Contact</a></li>
        <li class="nav-link"><a href="about.php">About</a></li>

        <!-- User Info Section -->
        <div id="user-info" style="display: none;">
          <img id="profile-pic" src="" alt="Profile Picture" class="profile-pic"/>
          <span id="user-name"></span>
          <a href="logout.php"><button class="btn">Logout</button></a>
        </div>

        <!-- Sign In Button -->
        <a href="login-user.php" id="login-btn"><button class="btn">Sign In</button></a>
      </ul>
    </nav>
