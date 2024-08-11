<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Forgot Password</title>
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
          <div class="title">Enter Email</div>
          <div class="content">
            <br>
            <?php
                        if(count($errors) > 0){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                            </div>
                            <?php
                        }
            ?>
            <form action="forgot-password.php" method="POST" autocomplete="">
              <div class="user-details">
              <div class="input-box">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email ?>">
              </div>
              </div>
              <div class="button">
                <input class="form-control button" type="submit" name="check-email" value="Continue">
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php include "./include/footer.php"; ?>
    
</body>
</html>