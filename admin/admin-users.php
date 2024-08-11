
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="./css/style.css">
  <title>Admin - Users Settings</title>
</head>
<body>
   <div class="container">
      <aside>
         <div class="top">
           <div class="logo">
             <h2>HBS</h2>
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">close</span>
           </div>
         </div>
         <!-- end top -->
         <div class="sidebar">
            <!-- Sidebar content -->
            <a href="admin-dashboard.php"><span class="material-symbols-sharp">grid_view </span><h3>Dashboard</h3></a>
            <a href="#"><span class="material-symbols-sharp">book </span><h3>Bookings</h3></a>
            <a href="admin-users.php" class="active"><span class="material-symbols-sharp">person_outline </span><h3>Users</h3></a>
            <a href="#"><span class="material-symbols-sharp">mail_outline </span><h3>Queries</h3><span class="msg_count">14</span></a>
            <a href="#"><span class="material-symbols-sharp">reviews </span><h3>Ratings & Review</h3></a>
            <a href="#"><span class="material-symbols-sharp">king_bed </span><h3>Rooms</h3></a>
            <a href="#"><span class="material-symbols-sharp">feature_search </span><h3>Features & Facilities</h3></a>
            <a href="#"><span class="material-symbols-sharp">tab </span><h3>Carousel</h3></a>
            <a href="admin-settings.php"><span class="material-symbols-sharp">settings </span><h3>Settings</h3></a>
            <a href="logout-admin.php"><span class="material-symbols-sharp">logout </span><h3>Logout</h3></a>
          </div>
      </aside>
      <!-- end aside -->
      
      <!-- start main part -->
      <main>
        <h2>Users</h2>
        <div class="recent_order">
         <h2>User Details</h2>
         <table class="table">
             <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
             </thead>
             <tbody>
                <?php
                require "../config/connection.php";
                $query = "SELECT * FROM usertable";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#editUserModal' data-id='{$row['id']}' data-name='{$row['name']}' data-email='{$row['email']}' data-phone='{$row['phone']}' data-status='{$row['status']}'>Edit</button>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Delete</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
         </table>
      </div>
    </main>
    <!-- end main part -->

    <!-- start right main -->
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

        <!-- Recent Updates Section -->
        <div class="recent_updates">
            <h2>Recent Updates</h2>
            <div class="updates">
                <?php
                require "./ajax/connection.php";
                $query = "SELECT name, email, created_at FROM usertable ORDER BY created_at DESC LIMIT 5";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='update'>
                            <div class='profile-photo'>
                                <img src='./images/profile-placeholder.jpg' alt='Profile Photo'/>
                            </div>
                            <div class='message'>
                                <p><b>{$row['name']}</b> signed up on {$row['created_at']}</p>
                            </div>
                          </div>";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- end right main -->

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Include jQuery, Bootstrap, and Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      let deleteId = null;

      $(document).on('click', '.delete-btn', function() {
          deleteId = $(this).data('id');
          $('#deleteConfirmModal').modal('show');
      });

      $('#confirmDelete').click(function() {
          $.ajax({
              type: 'POST',
              url: 'delete-user.php',
              data: { delete_id: deleteId },
              success: function(response) {
                  const result = JSON.parse(response);
                  if (result.status === 'success') {
                      toastr.success(result.message);
                      $(`button[data-id="${deleteId}"]`).closest('tr').remove();
                  } else {
                      toastr.error(result.message);
                  }
                  $('#deleteConfirmModal').modal('hide');
              }
          });
      });
    </script>
</body>
</html>