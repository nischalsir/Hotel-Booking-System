</body>
</html>

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Reset Code</title>
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
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
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
            <form action="reset-code.php" method="POST" autocomplete="off">
              <div class="user-details">
              <div class="input-box">
                <label for="email">Email</label>
                <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
              </div>
              </div>
              <div class="button">
              <input class="form-control button" type="submit" name="check-reset-otp" value="Submit">
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php include "./include/footer.php"; ?>
</body>
</html>