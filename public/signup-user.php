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
  <!-- Add Font Awesome for eye icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* Add this to your css/style.css or inside this <style> */
    .invalid-password {
        border: 2px solid red;
        box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
    }

    .password-warning {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
  </style>
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
          if (count($errors) > 0) {
              echo '<div class="alert alert-danger text-center">';
              foreach ($errors as $showerror) {
                  echo $showerror . '<br>';
              }
              echo '</div>';
          }
        ?>

        <form action="signup-user.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="flex flex-col gap-6" onsubmit="validateForm(event)">
          <input class="p-3 rounded-xl border" type="text" placeholder="Enter your name" name="name" id="name" required>
          <input class="p-3 rounded-xl border" type="email" placeholder="Enter your email" name="email" id="email" required>
          <input class="p-3 rounded-xl border" type="number" placeholder="Enter your phone number" id="phone" name="phone" required>
          
          <!-- Password field -->
          <div class="relative">
            <input class="p-3 rounded-xl border w-full" type="password" placeholder="Enter your password" id="password" name="password" required>
            <!-- Eye icon to toggle password visibility -->
            <span class="eye-icon" onclick="togglePassword()">
              <i id="eyeIcon" class="fa fa-eye-slash"></i> <!-- Eye icon by default -->
            </span>
          </div>

          <!-- Password warning message -->
          <div id="passwordWarning" class="password-warning"></div>

          <div class="flex items-center gap-4">
            <div class="col-span-full">
              <label for="photo" class="block text-sm/6 font-medium text-gray-700">Photo</label>
              <div class="mt-2 flex items-center gap-x-3">
                <img id="imagePreview" class="h-12 w-12 rounded-full object-cover border border-gray-300" alt="profile picture" src="./images/user.png">
                <label class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                  Upload
                  <input type="file" name="profile_picture" id="profile_picture" class="hidden" onchange="previewImage(event)" required>
                </label>
              </div>
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

  <script>
    // Function to preview uploaded image
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

    // Function to validate the password and apply the glow effect
    function validatePassword() {
        const password = document.getElementById("password").value.trim();
        const passwordField = document.getElementById("password");
        const warningText = document.getElementById("passwordWarning");

        // Password validation regex
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;

        if (!passwordRegex.test(password)) {
            // Add glow effect and show warning
            passwordField.classList.add("invalid-password");
            warningText.textContent = "Password must be 8-16 characters long, include at least one letter, one number, and one special character.";
        } else {
            // Remove glow effect and hide warning
            passwordField.classList.remove("invalid-password");
            warningText.textContent = "";
        }
    }

    // Call the function whenever the user types in the password field
    document.getElementById("password").addEventListener("input", validatePassword);

    // Remove the glow effect when the password field loses focus
    document.getElementById("password").addEventListener("blur", function () {
        const passwordField = document.getElementById("password");
        passwordField.classList.remove("invalid-password");
        document.getElementById("passwordWarning").textContent = "";
    });

    // Function to toggle password visibility and change eye icon
    function togglePassword() {
      const passwordField = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");

      if (passwordField.type === "password") {
        passwordField.type = "text"; // Show password
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye"); // Switch to eye-slash icon
      } else {
        passwordField.type = "password"; // Hide password
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash"); // Switch back to regular eye icon
      }
    }
  </script>
</body>
</html>
