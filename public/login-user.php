<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Login Page | Nischal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
<header class="header_navigation" id="header_navigation">
    
    <div class="main_container">
        
        <nav class="navigation_bar">
            <!-- Mobile toggle -->
            <input type="checkbox" id="navigation_toggle" name="dropdown">
            <div class="navigation_extras">
                <div class="theme_toggle">
                    <i class="ri-sun-line" id="sun_icon"></i>
                    <i class="ri-moon-line" id="moon_icon"></i>
                </div>
                <!-- Right side menu -->
                <a href="login-user.php" class="navigation_signin">Sign in</a>

                <label for="navigation_toggle">
                    <div class="navigation_open" id="navigation_open">
                        <i class="ri-menu-line"></i>
                    </div>
                    <div class="navigation_close" id="navigation_close">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="1.9"
                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </label>
            </div>

            <!-- Logo -->
            <div href="#" class="navigation_container">
                <div class="navigation_logo">
                    <i class="ri-hotel-fill"></i>
                </div>
                <!-- Centered menu -->
                <ul class="navigation_list">
                    <li class="navigation_item">
                        <a href="../public/index.html"" class="navigation_link">Home</a>
                    </li>
                    <li class="navigation_item">
                        <a href="#about" class="navigation_link">Booking</a>
                    </li>
                    <li class="navigation_item">
                        <a href="#services" class="navigation_link">About</a>
                    </li>
                    <li class="navigation_item">
                        <a href="#training" class="navigation_link">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<script src="./js/header.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="login-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">Login Form</h2>
                    <p class="text-center">Login with your email and password.</p>
                    <?php
                    if(count($errors) > 0){
                        echo '<div class="alert alert-danger text-center">';
                        foreach($errors as $showerror){
                            echo $showerror . '<br>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="pass" placeholder="Password" required>
                    </div>
                    <div class="link forget-pass text-left"><a href="forgot-password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Login">
                    </div>
                    <div class="link login-link text-center">Not yet a member? <a href="signup-user.php">Signup now</a></div>
                </form>
            </div>
        </div>
    </div>
    <script>
    let pass = document.getElementById("pass");
    if (pass.value.length >= 8) {
        console.log("Password is at least 8 characters long.");
    } else {
        console.log("Password is less than 8 characters long.");
    }
    </script>
</body>
</html>
