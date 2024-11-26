<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'hotel_booking');

if (!isset($_SESSION['admin_id']) || !$_SESSION['requires_password_change']) {
    header('Location: index.php'); // Redirect to login if accessed directly
    exit();
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $errors['password'] = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $admin_id = $_SESSION['admin_id'];

        // Update the password and reset temp_password
        $stmt = $con->prepare("UPDATE admin_cred SET password = ?, temp_password = NULL, is_temp_password = 0 WHERE sr_no = ?");
        $stmt->bind_param("si", $hashed_password, $admin_id);

        if ($stmt->execute()) {
            unset($_SESSION['requires_password_change']);
            echo "<script>alert('Password changed successfully. Please log in again.');</script>";
            header("Location: index.php");
            exit();
        } else {
            $errors['password'] = "An error occurred. Please try again.";
        }

        $stmt->close();
    }
}
?>
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
    <title>Change Password</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="post" class="sign-in-form">
            <h2 class="title">Change Password</h2>
            
            <!-- New Password Field -->
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="new_password" placeholder="New Password" required />
            </div>
            
            <!-- Confirm Password Field -->
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="confirm_password" placeholder="Confirm Password" required />
            </div>
            
            <!-- Display Errors -->
            <?php
            if (isset($errors['password'])) {
              echo '<p class="error-text">' . $errors['password'] . '</p>';
            }
            ?>
            
            <!-- Submit Button -->
            <input type="submit" value="Change Password" class="btn solid" />
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Change Password</h3>
            <p>
              Set a new secure password for your account.
            </p>
          </div>
          <img src="img/password-reset.png" class="image" alt="Change Password" />
        </div>
      </div>
    </div>
  </body>
</html>
