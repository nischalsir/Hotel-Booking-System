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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.tailwindcss.com"></script>
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

    <section class="bg-gray-50 min-h-screen flex items-center justify-center">
        <!-- Reset Code Form Container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-xl p-8 w-full">
            <!-- Form -->
            <div class="w-full">
                <h2 class="font-bold text-2xl text-[#002D74]">Reset Code Verification</h2>
                <p class="text-xs mt-4 text-[#002D74]"></p>
                
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
                
                <form action="reset-code.php" method="POST" autocomplete="off" class="flex flex-col gap-4">
                    <input class="p-2 mt-8 rounded-xl border" type="number" name="otp" placeholder="Enter code" required>
                    <button class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300" type="submit" name="check-reset-otp" value="Submit">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <?php include "./include/footer.php"; ?>
</body>
</html>
