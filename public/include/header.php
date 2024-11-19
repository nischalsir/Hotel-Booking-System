<?php
session_start();
// Check if user is logged in
$is_logged_in = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
                <?php 
                // Fetch profile picture path from session
                $profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
                
                // Ensure profile picture path is correctly set
                $profile_pic_path = !empty($profile_picture) ? htmlspecialchars($profile_picture) : 'uploads/default_profile_picture.png';
                ?>
                <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture" class="profile-pic" />
                <a href="logout.php"><button class="btn">Logout</button></a>
            <?php else: ?>
                <a href="login-user.php"><button class="btn">Sign In</button></a>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>
