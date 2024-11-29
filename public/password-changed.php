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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/form.css">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
    <title>Password changed</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <section class="bg-gray-50 min-h-screen flex items-center justify-center">
        <!-- Create New Password Container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-lg p-8 w-full">
            <!-- Form -->
            <div class="w-full">
                <h2 class="font-bold text-2xl text-[#002D74]">Password Changed Successfully!</h2>
                <p class="text-xs mt-4 text-[#002D74]"></p>

                <?php 
                if(isset($_SESSION['info'])){
                    ?>
                    <div class="alert alert-success text-center">
                    <?php echo $_SESSION['info']; ?>
                    </div>
                    <?php
                }
                ?>
                
                <!-- Password Form -->
                <form action="login-user.php" method="POST" class="flex flex-col gap-6">
                    <button class="bg-[#002D74] rounded-xl text-white py-3 hover:scale-105 duration-300 mt-4 w-full" type="submit" name="login-now" value="Login Now">LogIn</button>
                </form>
            </div>
        </div>
    </section>

    <?php include "./include/footer.php"; ?>
    
</body>
</html>
<body>

