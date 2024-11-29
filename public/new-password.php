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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
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
                <h2 class="font-bold text-2xl text-[#002D74]">Create a New Password</h2>
                <p class="text-xs mt-4 text-[#002D74]">Please create a new password for your account.</p>
                
                <!-- Success Message -->
                <?php 
                if(isset($_SESSION['info'])){
                    echo '<div class="alert alert-success text-center bg-green-100 text-green-800 p-4 rounded-xl mb-4">';
                    echo $_SESSION['info'];
                    echo '</div>';
                }
                ?>
                
                <!-- Error Messages -->
                <?php
                if(count($errors) > 0){
                    echo '<div class="alert alert-danger text-center bg-red-100 text-red-800 p-4 rounded-xl mb-4">';
                    foreach($errors as $showerror){
                        echo $showerror . '<br>';
                    }
                    echo '</div>';
                }
                ?>
                
                <!-- Password Form -->
                <form action="new-password.php" method="POST" autocomplete="off" class="flex flex-col gap-6">
                    <div class="input-box">
                        <label for="password" class="text-lg font-medium">New Password</label>
                        <input class="p-3 rounded-xl border w-full" type="password" name="password" placeholder="Create new password" required>
                    </div>

                    <div class="input-box">
                        <label for="cpassword" class="text-lg font-medium">Confirm Password</label>
                        <input class="p-3 rounded-xl border w-full" type="password" name="cpassword" placeholder="Confirm your password" required>
                    </div>

                    <button class="bg-[#002D74] rounded-xl text-white py-3 hover:scale-105 duration-300 mt-4 w-full" type="submit" name="change-password" value="Change">Change Password</button>
                </form>
            </div>
        </div>
    </section>

    <?php include "./include/footer.php"; ?>
</body>
</html>
