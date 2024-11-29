<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" type="image/png" href="../admin/img/hotel.png">
  <title>HBS - About Us</title>
</head>
<body>
  <?php include('./include/header.php');?>

  <header class="header">
    <div class="header-img">
      <div class="header-content">
        <h1>About Us</h1>
        <p>Learn more about our company and our mission.</p>
      </div>
    </div>
  </header>

  <section class="section about-us">
    <div class="about-content">
      <h2 class="section-title">Who We Are</h2>
      <p>
        At HBS, we are passionate about making your hotel booking experience as seamless and enjoyable as possible. With a user-friendly interface and a wide selection of hotels worldwide, we aim to provide you with the best options for your stay.
        Our team of travel enthusiasts is dedicated to helping you find the perfect accommodation for your needs, whether you are traveling for business or leisure. We strive to offer the best prices and exceptional customer service to make your journey memorable.
      </p>
    </div>
    <br>
    <br>
    <div class="team-section">
      <h2 class="section-title">Our Team</h2>
      <div class="team-grid">
        <div class="team-card">
          <img src="./images/nischal.jpg" alt="Nischal Pandey" />
          <div class="team-card-content">
            <h4>Nischal Pandey</h4>
            <p>CEO & Founder</p>
          </div>
        </div>
        <div class="team-card">
          <img src="./images/tarani.jpg" alt="Tarani Panta" />
          <div class="team-card-content">
            <h4>Tarani Panta</h4>
            <p>Chief Technology Officer</p>
          </div>
        </div>
        <div class="team-card">
          <img src="./images/niranjan.jpg" alt="Niranjan Shah" />
          <div class="team-card-content">
            <h4>Niranjan Shah</h4>
            <p>Customer Support Lead</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include('./include/footer.php');?>
</body>
</html>
