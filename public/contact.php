<?php
require_once "../config/contact_messages.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>HBS - Contact Us</title>
</head>
<body>
  <?php include "include/header.php" ?>
  <div id="notification" class="notification">
  <span id="notification-message"></span>
  <span id="notification-close" class="close-btn">&times;</span>
</div>

  <header class="header">
    <div class="header-img">
      <div class="header-content">
        <h1>Contact Us</h1>
        <p>Get in touch with us for any inquiries or feedback.</p>
      </div>
    </div>
  </header>

  <section class="section contact">
    <div class="contact-info">
      <div class="contact-details">
        <h2 class="section-title">Contact Information</h2>
        <ul>
          <li><i class="ri-map-pin-line"></i> 123 Putali Sadak, Kathmandu, Nepal</li>
          <li><i class="ri-phone-line"></i> +977 9865060952</li>
          <li><i class="ri-mail-line"></i> info@nischalpandey.com</li>
        </ul>
      </div>
      <div class="contact-form">
        <h2 class="section-title">Send Us a Message</h2>
        <form action="contact.php" method="post">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4" required></textarea>
          </div>
          <button type="submit" name="submit" class="btn">Send Message</button>
        </form>
      </div>
    </div>
  </section>

  <?php include "include/footer.php" ?>
  
  <script>
    // Display success message
    <?php if (!empty($success)) { ?>
      alert("<?php echo $success; ?>");
    <?php } ?>

    // Display error messages
    <?php if (!empty($errors)) { ?>
      <?php foreach ($errors as $error) { ?>
        alert("<?php echo $error; ?>");
      <?php } ?>
    <?php } ?>
  </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function showNotification(message, type) {
    const notification = document.getElementById('notification');
    const messageElem = document.getElementById('notification-message');
    const closeBtn = document.getElementById('notification-close');

    // Set message and type
    messageElem.textContent = message;
    notification.className = `notification ${type} show`;

    // Close button event listener
    closeBtn.addEventListener('click', function() {
      notification.classList.remove('show');
    });

    // Hide notification after 5 seconds
    setTimeout(function() {
      notification.classList.remove('show');
    }, 5000);
  }

  // Example usage based on PHP variables
  <?php if (!empty($success)) { ?>
    showNotification("<?php echo $success; ?>", "success");
  <?php } ?>
  <?php if (!empty($errors)) { ?>
    <?php foreach ($errors as $error) { ?>
      showNotification("<?php echo $error; ?>", "error");
    <?php } ?>
  <?php } ?>
});
</script>


</body>
</html>
