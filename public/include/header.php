<?php
$con = mysqli_connect('localhost', 'root', '', 'hotel_booking');
// Start session and check login status
session_start();
$is_logged_in = isset($_SESSION['email']);
$profile_pic_path = 'uploads/default_profile_picture.png';  // Default image if not set

if ($is_logged_in) {
    // Get the user's profile picture from the database
    $email = $_SESSION['email'];  // User's email stored in session
    $query = "SELECT profile_picture FROM usertable WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $profile_pic_path = $user_data['profile_picture'];  // Retrieve the profile picture path
    }
}
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
</body>
</html>
