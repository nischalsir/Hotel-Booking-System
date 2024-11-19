<?php require_once "../config/controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/form.css">
  <title>HBS - Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // JavaScript to preview uploaded image
    function previewImage(event) {
      const preview = document.getElementById('imagePreview');
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function () {
          preview.src = reader.result;
        };
        reader.readAsDataURL(file);
      }
    }

    function validateForm(event) {
      const termsCheckbox = document.getElementById("terms");
      if (!termsCheckbox.checked) {
        alert("You must agree to the terms and conditions before signing up.");
        event.preventDefault(); // Prevent form submission
      }
    }
  </script>
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
    <!-- signup container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-4xl w-full p-8">
      <!-- form -->
      <div class="w-full">
        <h2 class="font-bold text-2xl text-[#002D74] text-center">Sign Up</h2>
        <p class="text-xs mt-4 text-[#002D74] text-center">Create an account to enjoy our services</p>
        <?php
          if(count($errors) > 0){
              echo '<div class="alert alert-danger text-center">';
              foreach($errors as $showerror){
                  echo $showerror . '<br>';
              }
              echo '</div>';
          }
        ?>
        <form action="signup-user.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="flex flex-col gap-6" onsubmit="validateForm(event)">
          <input class="p-3 rounded-xl border" type="text" placeholder="Enter your name" name="name" id="name" required>
          <input class="p-3 rounded-xl border" type="email" placeholder="Enter your email" name="email" id="email" required>
          <input class="p-3 rounded-xl border" type="number" placeholder="Enter your phone number" id="phone" name="phone" required>
          <input class="p-3 rounded-xl border" type="password" placeholder="Enter your password" id="password" name="password" required>

          <div class="flex items-center gap-4">
            <!-- Upload button -->
            <div>
              <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Upload Profile Picture</label>
              <label class="p-3 border border-gray-300 rounded-xl bg-white hover:bg-gray-200 cursor-pointer block text-center">
                Choose File
                <input type="file" name="profile_picture" id="profile_picture" class="hidden" onchange="previewImage(event)" required>
              </label>
            </div>

            <!-- Preview image -->
            <div class="mt-4">
              <img id="imagePreview" class="h-16 w-16 rounded-full object-cover border border-gray-300" src="" alt="Image Preview">
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Gender</label>
            <div class="flex gap-4 mt-2">
              <label class="flex items-center">
                <input type="radio" name="gender" value="Male" required>
                <span class="ml-2">Male</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="gender" value="Female" required>
                <span class="ml-2">Female</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="gender" value="Unknown" required>
                <span class="ml-2">Prefer not to say</span>
              </label>
            </div>
          </div>
          
          <div>
            <label class="flex items-center">
              <input type="checkbox" id="terms" name="terms">
              <span class="ml-2 text-sm">I agree to the <a href="#" class="text-blue-500 underline">terms and conditions</a></span>
            </label>
          </div>
          
          <button class="bg-[#002D74] rounded-xl text-white py-3 hover:scale-105 duration-300" type="submit" name="signup" value="Sign Up">Sign Up</button>
        </form>
        <p class="mt-5 text-xs text-[#002D74] text-center">Already have an account? <a href="login-user.php" class="text-blue-500">Login</a></p>
      </div>
    </div>
  </section>
  <br>
  <?php include "./include/footer.php"; ?>
</body>
</html>
