<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/form.css">
  <meta charset="UTF-8">
  <title>HBS - Sign In</title>
  <link rel="icon" type="image/png" href="../admin/img/hotel.png">
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
        <!-- login container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-xl p-8 items-center">
            <!-- form -->
            <div class="w-full">
                <h2 class="font-bold text-2xl text-[#002D74]">Forgot Password</h2>
                <p class="text-xs mt-4 text-[#002D74]"></p>
                <?php
                    if(count($errors) > 0){
                        echo '<div class="alert alert-danger text-center">';
                        foreach($errors as $showerror){
                            echo $showerror . '<br>';
                        }
                        echo '</div>';
                    }
                ?>
                <form action="forgot-password.php" method="POST" autocomplete="" class="flex flex-col gap-4">
                    <input class="p-2 mt-8 rounded-xl border" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email ?>">
                    <button class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300" type="submit" name="check-email" value="Continue">Continue</button>
                </form>
            </div>
        </div>
    </section>

    <?php include "./include/footer.php"; ?>
</body>
</html>
