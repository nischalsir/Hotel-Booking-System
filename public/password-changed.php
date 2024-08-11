<?php require_once "../config/controllerUserData.php"; ?>
<?php
if($_SESSION['info'] == false){
    header('Location: login-user.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
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
          <div class="title">Password Changed Sucessfully</div>
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
             <form action="login-user.php" method="POST">
              <div class="button">
                        <input class="form-control button" type="submit" name="login-now" value="Login Now">
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php include "./include/footer.php"; ?>
    
</body>
</html>