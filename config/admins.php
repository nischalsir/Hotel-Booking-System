<?php
require '../config/connection.php'; // Update the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_admin'])) {
        // Validate email
        if (!isset($_POST['delete_email']) || empty(trim($_POST['delete_email']))) {
            die("Error: Admin email is required.");
        }

        $delete_email = trim($_POST['delete_email']); // Capture admin email from the form

        // Prepare and execute the delete query
        $delete_query = $con->prepare("DELETE FROM admin_cred WHERE email = ?");
        $delete_query->bind_param("s", $delete_email);

        if ($delete_query->execute()) {
            echo "Admin with email $delete_email deleted successfully.";
        } else {
            echo "Error deleting admin: " . $delete_query->error;
        }

        $delete_query->close();
    } else {
        // Existing code for adding an admin
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phone']);

        // Validate email repetition
        $email_query = $con->prepare("SELECT COUNT(*) AS count FROM admin_cred WHERE email = ?");
        $email_query->bind_param("s", $email);
        $email_query->execute();
        $email_result = $email_query->get_result()->fetch_assoc();
        if ($email_result['count'] > 0) {
            die("Error: The email address is already registered.");
        }
        $email_query->close();

        // Validate phone number repetition
        $phone_query = $con->prepare("SELECT COUNT(*) AS count FROM admin_cred WHERE phone = ?");
        $phone_query->bind_param("s", $phone);
        $phone_query->execute();
        $phone_result = $phone_query->get_result()->fetch_assoc();
        if ($phone_result['count'] > 0) {
            die("Error: The phone number is already registered.");
        }
        $phone_query->close();

        // Base username using "hbs." + first name
        $base_username = 'hbs.' . strtolower(preg_replace('/\s+/', '', $first_name));

        // Find the highest existing suffix for the base username
        $username_query = $con->prepare("SELECT username FROM admin_cred WHERE username LIKE CONCAT(?, '%')");
        $username_query->bind_param("s", $base_username);
        $username_query->execute();
        $result = $username_query->get_result();

        $max_suffix = 0;
        while ($row = $result->fetch_assoc()) {
            if (preg_match('/(\d{4})$/', $row['username'], $matches)) {
                $max_suffix = max($max_suffix, intval($matches[1]));
            }
        }
        $username_query->close();

        // Increment the max suffix to generate a new username
        $new_suffix = str_pad($max_suffix + 1, 4, '0', STR_PAD_LEFT);
        $username = $base_username . $new_suffix;

        // Generate a random 8-character temporary password
        $temp_password_plain = bin2hex(random_bytes(4)); // Example: "A1b2C3d4"
        $hashed_temp_password = password_hash($temp_password_plain, PASSWORD_DEFAULT);

        // Handle profile picture upload
        if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_path']['tmp_name'];
            $fileName = $_FILES['image_path']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Validate file extension
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = 'admin_' . md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = 'uploads/';
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $profile_picture = $dest_path; // Save the new file path in $profile_picture
                } else {
                    die("Error: There was an error moving the uploaded file.");
                }
            } else {
                die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
            }
        } else {
            $profile_picture = 'uploads/default_profile_picture.png'; // Use default image if no file uploaded
        }

        // Insert data into the database
        $stmt = $con->prepare("INSERT INTO admin_cred (first_name, last_name, email, address, phone, username, temp_password, is_temp_password, image_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
        $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $address, $phone, $username, $hashed_temp_password, $profile_picture);

        if ($stmt->execute()) {
            echo "Admin added successfully.";

            // Send email with temporary password
            $to = $email;
            $subject = "Account Created - Hotel Booking System";
            $message = "
                <html>
                <head>
                <title>Account Created</title>
                </head>
                <body>
                <h2>Welcome to Hotel Booking System</h2>
                <p>Dear $first_name $last_name,</p>
                <p>Your account has been successfully created in the Hotel Booking System.</p>
                <p>Login Details:</p>
                <ul>
                    <li>Username: $username</li>
                    <li>Temporary Password: $temp_password_plain</li>
                </ul>
                <p>You are required to change your password upon your first login.</p>
                <p>Thank you,<br>Admin Hotel Booking System</p>
                </body>
                </html>
            ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: Admin HotelBookingSystem <admin@hotelbookingsystem.com>" . "\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent to $email.";
            } else {
                echo "Error: Failed to send email.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$con->close();
?>