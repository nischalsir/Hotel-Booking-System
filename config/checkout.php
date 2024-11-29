<?php
// Fetch booking data
$query = "
    SELECT 
        b.id AS booking_id,
        u.name AS user_name,
        u.phone AS user_phone,
        u.email AS user_email,
        r.room_type AS room_name,
        r.price AS room_price,
        b.guests,
        b.check_out_date
    FROM bookings AS b
    JOIN usertable AS u ON b.user_email = u.email
    JOIN rooms AS r ON b.room_id = r.id
    WHERE b.status = 'Confirmed'
    ORDER BY b.created_at DESC";

$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching bookings: " . mysqli_error($con));
}

// Handle checkout action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Initialize variables
    $booking_id = intval($_POST['booking_id'] ?? 0);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email'] ?? '');
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method'] ?? '');
    $discount_code = mysqli_real_escape_string($con, trim($_POST['discount_code'] ?? ''));
    $amount_paid = floatval($_POST['amount_paid'] ?? 0);
    $checkout_date = date("Y-m-d H:i:s");
    $discount_amount = 0;
    $final_amount = $amount_paid; // Default to amount paid
    $is_early_checkout = 0;
    $is_late_checkout = 0;

    // Validate user_email exists in usertable
    $email_check_query = "SELECT email FROM usertable WHERE email = '$user_email'";
    $email_check_result = mysqli_query($con, $email_check_query);
    if (!$email_check_result || mysqli_num_rows($email_check_result) == 0) {
        die("Error: User email does not exist.");
    }

    // Fetch booking details including room_name and guests
    $fetch_booking_query = "
        SELECT 
            b.check_out_date, 
            r.room_type AS room_name, 
            b.guests,
            r.price AS room_price
        FROM bookings AS b
        JOIN rooms AS r ON b.room_id = r.id
        WHERE b.id = $booking_id";
    $booking_result = mysqli_query($con, $fetch_booking_query);

    if ($booking_result && mysqli_num_rows($booking_result) > 0) {
        $booking_data = mysqli_fetch_assoc($booking_result);
        $original_checkout_date = $booking_data['check_out_date'];
        $room_name = $booking_data['room_name'];
        $guests = $booking_data['guests'];
        $room_price = $booking_data['room_price'];

        // Determine early or late checkout
        $is_early_checkout = strtotime($checkout_date) < strtotime($original_checkout_date) ? 1 : 0;
        $is_late_checkout = strtotime($checkout_date) > strtotime($original_checkout_date) ? 1 : 0;

        // Validate and apply discount code
        if (!empty($discount_code)) {
            $check_discount_query = "SELECT discount_percentage FROM discount_codes WHERE discount_code = '$discount_code' AND is_used = 0";
            $discount_result = mysqli_query($con, $check_discount_query);

            if ($discount_result && mysqli_num_rows($discount_result) > 0) {
                $discount_data = mysqli_fetch_assoc($discount_result);
                $discount_percentage = $discount_data['discount_percentage'];
                $discount_amount = ($amount_paid * $discount_percentage) / 100;
                $final_amount = $amount_paid - $discount_amount;

                // Mark the discount code as used
                $mark_used_query = "UPDATE discount_codes SET is_used = 1 WHERE discount_code = '$discount_code'";
                mysqli_query($con, $mark_used_query);
            }
        }

        // Save checkout details
        $insert_query = "
            INSERT INTO checkouts (
                booking_id, user_email, checkout_date, payment_method, 
                amount_paid, is_early_checkout, is_late_checkout, discount_code
            ) VALUES (
                $booking_id, 
                '$user_email', 
                '$checkout_date', 
                '$payment_method', 
                $final_amount, 
                $is_early_checkout, 
                $is_late_checkout, 
                " . (!empty($discount_code) ? "'$discount_code'" : "NULL") . "
            )";

        if (mysqli_query($con, $insert_query)) {
            // Delete the booking after successful checkout
            $delete_booking_query = "DELETE FROM bookings WHERE id = $booking_id";
            if (mysqli_query($con, $delete_booking_query)) {
                // Generate the bill HTML
                $bill = "
                    <html>
                    <head>
                        <title>Booking Invoice</title>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
                            .invoice-container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; }
                            .invoice-header { text-align: center; font-size: 24px; font-weight: bold; }
                            .invoice-body { margin-top: 20px; }
                            .invoice-footer { text-align: center; margin-top: 30px; font-size: 14px; color: #777; }
                            .invoice-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            .invoice-table th, .invoice-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
                            .invoice-table th { background-color: #f4f4f4; }
                        </style>
                    </head>
                    <body>
                        <div class='invoice-container'>
                            <div class='invoice-header'>Booking Invoice</div>
                            <div class='invoice-body'>
                                <p><strong>Customer Email:</strong> $user_email</p>
                                <p><strong>Room Type:</strong> $room_name</p>
                                <p><strong>Guests:</strong> $guests</p>
                                <p><strong>Checkout Date:</strong> $checkout_date</p>
                                <p><strong>Payment Method:</strong> $payment_method</p>

                                <table class='invoice-table'>
                                    <tr>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    <tr>
                                        <td>Room Charge</td>
                                        <td>Rs.$room_price</td>
                                        <td>$guests</td>
                                        <td>Rs." . ($room_price * $guests) . "</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' style='text-align: right;'><strong>Discount:</strong></td>
                                        <td>-" . number_format($discount_amount, 2) . "</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' style='text-align: right;'><strong>Final Amount:</strong></td>
                                        <td>Rs.$final_amount</td>
                                    </tr>
                                </table>
                            </div>
                            <div class='invoice-footer'>Thank you for choosing our service!</div>
                        </div>
                        <script>
                            window.onload = function() {
                                window.print();
                            };
                        </script>
                    </body>
                    </html>
                ";
                echo $bill;
                exit(); // Stop further processing
            } else {
                die("Error deleting booking: " . mysqli_error($con));
            }
        } else {
            die("Error inserting checkout: " . mysqli_error($con));
        }
    } else {
        die("Error: Booking not found.");
    }
}
?>