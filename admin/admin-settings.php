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
           <a href="admin-users.php">
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
           <a href="logout-admin.php">
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
        <h2>Settings</h2>

        <div class="card">
            <h2>Shut Down Website</h2>
            <div class="shutdown-container">
               <p>Shutdown website for maintenance</p>
               <label class="switch">
                     <input type="checkbox" id="shutdown" name="shutdown" <?php echo (isset($shutdown_status) && $shutdown_status == 1) ? 'checked' : ''; ?>>
                     <span class="slider"></span>
               </label>
            </div>
            <div id="shutdown-notification" class="notification"></div>
         </div>



    </main>

    <?php 
$con = mysqli_connect('localhost', 'root', '', 'hotel_booking');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $shutdown = isset($data['shutdown_status']) ? (int)$data['shutdown_status'] : 0;

    // Update the shutdown status in the database
    $query = "UPDATE settings SET shutdown = ? WHERE sr_no = 1"; // Adjust the query as needed
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $shutdown);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Shutdown status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update shutdown status.']);
    }

    $stmt->close();
    $con->close();
    exit;
}

// Fetch the current shutdown status from the database
$query = "SELECT shutdown FROM settings WHERE sr_no = 1"; // Adjust the query as needed
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $shutdown_status = $row['shutdown'];
} else {
    $shutdown_status = 0; // Default value if no record found
}

$con->close();
?>



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
  <script>
   document.addEventListener('DOMContentLoaded', function() {
    const shutdownCheckbox = document.getElementById('shutdown');
    const shutdownNotification = document.getElementById('shutdown-notification');

    // Function to show notification
    function showNotification(message) {
        shutdownNotification.textContent = message;
        shutdownNotification.classList.add('show');
        setTimeout(() => shutdownNotification.classList.remove('show'), 3000);
    }

    // Handle checkbox change
    shutdownCheckbox.addEventListener('change', function() {
        const shutdownStatus = shutdownCheckbox.checked ? 1 : 0;

        fetch('/admin/admin-settings.php', {  // Update this URL if needed
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ shutdown_status: shutdownStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message);
            } else {
                showNotification('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error: Unable to update shutdown status');
        });
    });
});

  </script>
   <script src="./js/script.js"></script>
</body>
</html>