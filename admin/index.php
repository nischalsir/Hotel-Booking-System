<?php require_once "../config/admin.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="./css/index.css" />
    <title>Admin - Log In</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="post" class="sign-in-form">
            <h2 class="title">Log In</h2>
            
            <!-- Username Field -->
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="admin_name" placeholder="Username" required />
            </div>
            
            <!-- Password Field -->
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="admin_pass" placeholder="Password" required />
            </div>
            
            <!-- Display Errors -->
            <?php
            if (isset($errors['login'])) {
              echo '<p class="error-text">' . $errors['login'] . '</p>';
            }
            ?>
            
            <!-- Submit Button -->
            <input type="submit" name="login" value="Login" class="btn solid" />
            
            <!-- Info Text -->
            <p class="info-text">If you forgot your credentials, please contact the developer.</p>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Admin Log In</h3>
            <p>
              Please enter the credentials provided by the developer.
            </p>
          </div>
          <img src="img/administrator.png" class="image" alt="Administrator" />
        </div>
      </div>
    </div>
  </body>
</html>
