<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>HBS - Sign Up</title>
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
    <div class="form">
        <div class="container">
            <div class="title">Registration</div>
            <div class="content">
                <?php
                if (count($errors) == 1) {
                    ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        foreach ($errors as $showerror) {
                            echo $showerror;
                        }
                        ?>
                    </div>
                    <?php
                } elseif (count($errors) > 1) {
                    ?>
                    <div class="alert alert-danger">
                        <?php
                        foreach ($errors as $showerror) {
                            ?>
                            <li><?php echo $showerror; ?></li>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <form action="signup-user.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Full Name</span>
                            <input type="text" placeholder="Enter your name" name="name" id="name" required />
                        </div>
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input type="email" placeholder="Enter your email" name="email" id="email" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Phone Number</span>
                            <input type="number" placeholder="Enter your phone number" id="phone" name="phone" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Password</span>
                            <input type="password" placeholder="Enter your password" id="password" name="password" required>
                        </div>
                        <div class="input-box">
                        <span class="details">Upload Picture</span>
                        <label for="profile_picture" class="custom-file-upload">
                            Choose Profile Picture
                        </label>
                            <input type="file" name="profile_picture" id="profile_picture" required />
                        </div>
                        
                    </div>
                    <div class="gender-details">
                        <span class="gender-title">Gender</span>
                        <div class="category">
                            <label for="male">
                                <input type="radio" id="male" name="gender" value="Male" required />
                                <span class="dot one"></span>
                                <span class="gender">Male</span>
                            </label>
                            <label for="female">
                                <input type="radio" id="female" name="gender" value="Female" required />
                                <span class="dot two"></span>
                                <span class="gender">Female</span>
                            </label>
                            <label for="unknown">
                                <input type="radio" id="unknown" name="gender" value="Unknown" required />
                                <span class="dot three"></span>
                                <span class="gender">Prefer not to say</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" id="terms" name="terms" required />
                        I agree to the <a href="#">terms and conditions</a>
                    </div>
                    <div class="button">
                        <input type="submit" name="signup" value="Sign Up">
                    </div>
                </form>
                <p>Already have an account? <a href="login-user.php">Login</a></p>
            </div>
        </div>
    </div>
    <?php include "./include/footer.php"; ?>
</body>
</html>