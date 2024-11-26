<?php
require '../config/connection.php'; // Update the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Set absolute path for uploads directory
    $target_dir = "C:/Users/nisch/OneDrive/Desktop/Project/HotelBookingSystem/admin/uploads/";
    $original_file_name = basename($_FILES["image"]["name"]);
    $file_extension = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

    // Validate image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("Error: File is not an image.");
    }

    // Check file size (limit to 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        die("Error: File size exceeds the 2MB limit.");
    }

    // Allow certain file formats
    if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    // Generate a unique file name using timestamp and username
    $unique_file_name = $username . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $unique_file_name;

    // Move uploaded file
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Error: There was an issue uploading your file.");
    }

    // Save relative path to the database
    $relative_path = "uploads/" . $unique_file_name;

    // Insert data into the database
    $stmt = $con->prepare("INSERT INTO admin_cred (first_name, last_name, email, address, phone, username, temp_password, is_temp_password, image) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $address, $phone, $username, $hashed_temp_password, $relative_path);

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
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
</head>
<body>
    <h2>Add New Admin</h2>
    <form action="admins.php" method="POST" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br>

        <label for="address">Address:</label>
        <textarea name="address" id="address" required></textarea><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="image">Profile Picture:</label>
        <input type="file" name="image" id="image" accept="image/*" required><br>

        <button type="submit" name="submit">Add Admin</button>
    </form>
</body>
</html>

