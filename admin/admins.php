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

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="image">Profile Picture:</label>
        <input type="file" name="image" id="image" accept="image/*" required><br>

        <button type="submit" name="submit">Add Admin</button>
    </form>
</body>
</html>
<?php
require '../config/connection.php'; // Update the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // File upload handling
    $target_dir = "../public/uploads/"; // Update path as needed
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (limit to 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        die("File is too large.");
    }

    // Allow certain file formats
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $stmt = $con->prepare("INSERT INTO admin_cred (first_name, last_name, address, phone, username, password, image) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $first_name, $last_name, $address, $phone, $username, $hashed_password, $target_file);

    if ($stmt->execute()) {
        echo "Admin added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>
