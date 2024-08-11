<?php require_once "../config/controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/form.css">
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
          <div class="title">Reset Code Verification</div>
          <div class="content">
            <br>
            <?php 
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
                    ?>
            <form action="new-password.php" method="POST" autocomplete="off">
              <div class="user-details">
                <div class="input-box">
                    <label for="password">New Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Create new password" required>
                </div>
                <div class="input-box">
                    <label for="password">Confirm Password</label>
                    <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
                </div>
              </div>
              <div class="button">
                <input class="form-control button" type="submit" name="change-password" value="Change">
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php include "./include/footer.php"; ?>
</body>
</html>