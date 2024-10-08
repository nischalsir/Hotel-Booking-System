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
    <link rel="stylesheet" href="css/form.css">
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

      <div class="form">
        <div class="container">
          <div class="title">OTP Verification</div>
          <div class="content">
            <br>
          <p>        <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?></p>
            <form action="signup-user.php" method="POST" autocomplete="">
              <div class="user-details">
              <div class="input-box">
                <label for="otp">Verification code</label>
                <input  type="number" name="otp" required placeholder="Enter your OTP" />
              </div>
              </div>
              <div class="button">
                  <input type="submit" name="check" value="Submit">
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php include "./include/footer.php"; ?>
</body>
</html>