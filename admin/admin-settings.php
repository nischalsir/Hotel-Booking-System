<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Settings</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
   <div class="container">
      <aside>
           
         <div class="top">
           <div class="logo">
             <h2>HBS</h2>
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
              close
              </span>
           </div>
         </div>
         <!-- end top -->
          <div class="sidebar">

            <a href="admin-dashboard.php">
              <span class="material-symbols-sharp">grid_view </span>
              <h3>Dashbord</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">book </span>
              <h3>Bookings</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">person_outline </span>
              <h3>Users</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">mail_outline </span>
              <h3>Queries</h3>
              <span class="msg_count">14</span>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">reviews </span>
              <h3>Ratings & Review</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">king_bed </span>
              <h3>Rooms</h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">feature_search </span>
              <h3>Features & Facilites </h3>
           </a>
           <a href="#">
              <span class="material-symbols-sharp">tab </span>
              <h3>Carousel</h3>
           </a>
           <a href="admin-settings.php" class="active">
              <span class="material-symbols-sharp">settings </span>
              <h3>Settings</h3>
           </a>
           <a href="">
              <span class="material-symbols-sharp">logout </span>
              <h3>Logout</h3>
           </a>

          </div>

      </aside>
      <!-- --------------
        end asid
      -------------------- -->

      <!-- --------------
        start main part
      --------------- -->

      <main>
        <h1>Settings</h1>

        <div class="card">
          <h2>Shut Down Website</h2>
          <form id="shutdown-form" method="post">
            <div class="shutdown-container">
              <p>Shutdown website for maintenance</p>
              <label class="switch">
                <input type="checkbox" name="shutdown" <?php echo (isset($shutdown_status) && $shutdown_status == 1) ? 'checked' : ''; ?>>
                <span class="slider"></span>
              </label>
            </div>
          </form>
          <div id="shutdown-notification" class="notification"></div>
    </main>

          <!----------------
        start right main 
      ---------------------->
      <div class="right">

<div class="top">
   <button id="menu_bar">
     <span class="material-symbols-sharp">menu</span>
   </button>

   <div class="theme-toggler">
     <span class="material-symbols-sharp active">light_mode</span>
     <span class="material-symbols-sharp">dark_mode</span>
   </div>
    <div class="profile">
       <div class="info">
           <p><b>Nischal</b></p>
           <p>Admin</p>
           <small class="text-muted"></small>
       </div>
       <div class="profile-photo">
         <img src="./img/admin.jpg" alt=""/>
       </div>
    </div>
</div>

  <div class="recent_updates">
     <h2>Recent Update</h2>
   <div class="updates">
      <div class="update">
         <div class="profile-photo">
            <img src="./images/profile-4.jpg" alt=""/>
         </div>
        <div class="message">
           <p><b>Babar</b> Recived his order of USB</p>
        </div>
      </div>
      <div class="update">
        <div class="profile-photo">
        <img src="./images/profile-3.jpg" alt=""/>
        </div>
       <div class="message">
          <p><b>Ali</b> Recived his order of USB</p>
       </div>
     </div>
     <div class="update">
      <div class="profile-photo">
         <img src="./images/profile-2.jpg" alt=""/>
      </div>
     <div class="message">
        <p><b>Ramzan</b> Recived his order of USB</p>
     </div>
   </div>
  </div>
  </div>


   <div class="sales-analytics">
     <h2>Sales Analytics</h2>

      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">shopping_cart</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Onlion Orders</h3>
            <small class="text-muted">Last seen 2 Hours</small>
          </div>
          <h5 class="danger">-17%</h5>
          <h3>3849</h3>
        </div>
      </div>
      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">shopping_cart</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Onlion Orders</h3>
            <small class="text-muted">Last seen 2 Hours</small>
          </div>
          <h5 class="success">-17%</h5>
          <h3>3849</h3>
        </div>
      </div>
      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">shopping_cart</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Onlion Orders</h3>
            <small class="text-muted">Last seen 2 Hours</small>
          </div>
          <h5 class="danger">-17%</h5>
          <h3>3849</h3>
        </div>
      </div>
   
  

</div>

      <div class="item add_product">
            <div>
            <span class="material-symbols-sharp">add</span>
            </div>
     </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
      const shutdownForm = document.getElementById('shutdown-form');
      const settingForm = document.getElementById('setting-form');
      const shutdownNotification = document.getElementById('shutdown-notification');
      const settingNotification = document.getElementById('setting-notification');

      // Function to show notification
      function showNotification(notificationElement, message) {
          notificationElement.textContent = message;
          notificationElement.classList.add('show');
          setTimeout(() => notificationElement.classList.remove('show'), 3000);
      }

      // Handle shutdown form changes
      shutdownForm.addEventListener('change', function() {
          const formData = new FormData(shutdownForm);

          fetch('', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  showNotification(shutdownNotification, data.message);
              } else {
                  showNotification(shutdownNotification, 'Error: ' + data.message);
              }
          })
          .catch(error => {
              console.error('Error:', error);
              showNotification(shutdownNotification, 'Error: Unable to update shutdown status');
          });
      });
    });

   </script>

   <script src="./js/script.js"></script>
</body>
</html>