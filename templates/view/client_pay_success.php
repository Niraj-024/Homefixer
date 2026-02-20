<?php
include('../controller/db_conn.php');
include('../controller/session.php');

// Extract and decode eSewa response data
parse_str(parse_url($_GET['q'], PHP_URL_QUERY), $params);
$payload = isset($params['data']) ? $params['data'] : '';

if ($payload) {
    $decoded = json_decode(base64_decode($payload), true);

    if ($decoded && $decoded['status'] === 'COMPLETE') {
        $transaction_id = $decoded['transaction_code'];
        $transaction_uuid = $decoded['transaction_uuid']; // e.g., BOOK1_xxxxxx
        $amount = floatval($decoded['total_amount']); // convert to float just in case

        // Extract booking ID from transaction UUID
        $booking_id_str = explode('_', $transaction_uuid)[0]; // e.g., "BOOK1"
        $booking_id = (int) str_replace("BOOK", "", $booking_id_str);

        $payment_status = "paid";
        $payment_method = "eSewa";
        $payment_date = date("Y-m-d H:i:s");
        $user_id = $_SESSION['id'];

        // Check if payment record already exists
        $check = $conn->query("SELECT * FROM payment WHERE booking_id = $booking_id");

        if ($check && $check->num_rows > 0) {
            // Update payment record
            $update_payment = $conn->query("UPDATE payment 
                SET payment_method = '$payment_method',
                    payment_status = '$payment_status',
                    transaction_id = '$transaction_id',
                    payment_date = '$payment_date'
                WHERE booking_id = $booking_id");

            if (!$update_payment) {
                echo "Payment update failed: " . $conn->error;
            }
        } else {
            // Insert payment record (fallback)
            $insert_payment = $conn->query("INSERT INTO payment 
                (booking_id, user_id, amount, payment_method, payment_status, transaction_id, payment_date)
                VALUES ($booking_id, $user_id, $amount, '$payment_method', '$payment_status', '$transaction_id', '$payment_date')");

            if (!$insert_payment) {
                echo "Payment insert failed: " . $conn->error;
            }
        }

        // Update bookings table payment status and updated_at
        $update_booking = $conn->query("UPDATE bookings 
            SET payment_status = '$payment_status',
                updated_at = '$payment_date'
            WHERE booking_id = $booking_id");

        if (!$update_booking) {
            echo "Booking update failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container a, span {
            text-decoration: none;
            font-weight: 500;
            color: blue;
        }
        h1 {
            color: #00aa00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <p>Your payment has been received successfully.</p>
        <p><strong>Transaction ID:</strong> <span><?php echo isset($transaction_id) ? htmlspecialchars($transaction_id) : 'Unknown'; ?></span></p>
        <a href="client_book_current.php">Click to go back to Homepage</a>
    </div>
</body>
</html>
