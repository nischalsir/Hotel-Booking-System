<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/form.css">
  <title>HBS - Sign In</title>
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
          <div class="title">Log In</div>
          <div class="content">
          <?php
          if(count($errors) > 0){
              echo '<div class="alert alert-danger text-center">';
              foreach($errors as $showerror){
                  echo $showerror . '<br>';
              }
              echo '</div>';
          }
          ?>
            <form action="login-user.php" method="post">
              <div class="user-details">
              <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email" required value="<?php echo $email ?>">
              </div>
              <div class="input-box">
                <label for="pass">Password</label>
                <input type="password" name="password" id="pass" required>
              </div>
              <a href="forgot-password.php">Forgot password?</a>
              </div>
              <div class="button">
                  <input type="submit" name="login" value="Login">
              </div>
              <p>Don't have an account? <a href="signup-user.php">Sign Up</a></p>
            </form>
          </div>
        </div>
      </div>
      <?php include "./include/footer.php"; ?>
</body>
</html>
