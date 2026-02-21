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
        $amount = floatval($decoded['total_amount']); // total paid amount

        // Extract booking ID from transaction UUID
        $booking_id_str = explode('_', $transaction_uuid)[0]; // e.g., "BOOK1"
        $booking_id = (int) str_replace("BOOK", "", $booking_id_str);

        $payment_status = "paid";
        $payment_method = "eSewa";
        $payment_date = date("Y-m-d H:i:s");

        // Update bookings table: status = paid, save amount and transaction_id
        $update_booking = $conn->query("UPDATE bookings 
            SET status = '$payment_status', 
                payment_amount = '$amount', 
                transaction_id = '$transaction_id', 
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
        body { text-align:center; font-family:Arial,sans-serif; background:#f2f2f2; }
        .container { max-width:600px; margin:60px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
        .container a, span { text-decoration:none; font-weight:500; color:blue; }
        h1 { color:#00aa00; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <p>Your payment has been received successfully.</p>
        <p><strong>Transaction ID:</strong> <span><?php echo isset($transaction_id) ? htmlspecialchars($transaction_id) : 'Unknown'; ?></span></p>
        <a href="client_book_history.php">Go to Booking History</a>
    </div>
</body>
</html>