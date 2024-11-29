<?php
// Fetch messages from the database
$search_query = '';
$stmt = $con->prepare("SELECT id, name, email, message, created_at, reply FROM contact_messages ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'])) {
    $message_id = intval($_POST['message_id']);
    $reply = trim($_POST['reply']);
    $stmt = $con->prepare("UPDATE contact_messages SET reply = ? WHERE id = ?");
    $stmt->bind_param("si", $reply, $message_id);
    if ($stmt->execute()) {
        // Fetch the recipient's email for sending the reply
        $email_stmt = $con->prepare("SELECT email FROM contact_messages WHERE id = ?");
        $email_stmt->bind_param("i", $message_id);
        $email_stmt->execute();
        $email_result = $email_stmt->get_result()->fetch_assoc();
        $recipient_email = $email_result['email'];
        $email_stmt->close();

        // Send the reply via email
        $subject = "Reply to Your Message";
        $message = "
        <html>
        <head>
            <title>Reply from Hotel Booking System</title>
        </head>
        <body>
            <p>Dear Client,</p>
            <p>Thank you for reaching out to us. Below is our response to your message:</p>
            <blockquote>
                <p>" . htmlspecialchars($reply) . "</p>
            </blockquote>
            <p>Best Regards,<br>Hotel Booking System</p>
        </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Hotel Booking System <no-reply@hotelbookingsystem.com>" . "\r\n";

        mail($recipient_email, $subject, $message, $headers);

        header("Location: messages.php?reply_sent=true");
        exit;
    }
    $stmt->close();
}
?>