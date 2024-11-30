<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/form.css">
  <meta charset="UTF-8">
    <title>Login | Class</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../admin/img/hotel.png">
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

    <section class="bg-gray-50 min-h-screen flex items-center justify-center">
  <!-- login container -->
  <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
    <!-- form -->
    <div class="md:w-1/2 px-8 md:px-16">
      <h2 class="font-bold text-2xl text-[#002D74]">Login</h2>
      <p class="text-xs mt-4 text-[#002D74]">If you are already a member, easily log in</p>
      <?php
          if(count($errors) > 0){
              echo '<div class="alert alert-danger text-center">';
              foreach($errors as $showerror){
                  echo $showerror . '<br>';
              }
              echo '</div>';
          }
          ?>
      <form action="login-user.php" method="post" class="flex flex-col gap-4">
        <input class="p-2 mt-8 rounded-xl border"  type="email" name="email" required value="<?php echo $email ?>" placeholder="Enter your email">
        <div class="relative">
          <input class="p-2 rounded-xl border w-full" placeholder="Enter your password" type="password" name="password" id="pass" required>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
          </svg>
        </div>
        <button class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300" type="submit" name="login" value="Login">Login</button>
      </form>

      <div class="mt-6 grid grid-cols-3 items-center text-gray-400">
        <hr class="border-gray-400">
        <p class="text-center text-sm">OR</p>
        <hr class="border-gray-400">
        <a href="../admin/index.php">
        <button class="bg-[#971c1c] rounded-xl text-white py-2 hover:scale-105 duration-300" name="login">Admin</button>
        </a>
      </div>

      <div class="mt-5 text-xs border-b border-[#002D74] py-4 text-[#002D74]">
        <a href="forgot-password.php">Forgot your password?</a>
      </div>

      <div class="mt-3 text-xs flex justify-between items-center text-[#002D74]">
        <p>Don't have an account?</p>
        <button class="py-2 px-5 bg-white border rounded-xl hover:scale-110 duration-300"><a href="signup-user.php">Sign Up</a></button>
      </div>
    </div>

    <!-- image -->
    <div class="md:block hidden w-1/2">
      <img class="rounded-2xl" src="./images/Login page picture.jpg">
    </div>

  </div>
</section>
      <?php include "./include/footer.php"; ?>
</body>
</html>