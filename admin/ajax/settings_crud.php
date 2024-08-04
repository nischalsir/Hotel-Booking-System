<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $site_title = $_POST['site_title'];
    $site_about = $_POST['site_about'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "hotel_booking");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update data in the database
    $sql = "UPDATE settings SET site_title='$site_title', site_about='$site_about' WHERE sr_no=1";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the settings page with a success flag
        header("Location: admin-settings.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
