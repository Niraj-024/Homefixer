<?php
include('../controller/db_conn.php');
include('../controller/session.php');

if (!isset($_SESSION['role'])) {
    header("location: login.php");
    exit();
}

if ($_SESSION['role'] == 'spr') {
    header("location: spr_profile.php");
    exit();
} elseif ($_SESSION['role'] == 'admin') {
    header("location: admin.php");
    exit();
}

include('client_header.php');

// Get booking ID
$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

if ($booking_id <= 0) {
    echo "<div class='alert alert-danger'>Invalid booking ID.</div>";
    include('client_footer.php');
    exit();
}

// Fetch booking and user
$sql = "SELECT b.*, u.uname FROM bookings b
        JOIN user u ON b.user_id = u.u_id
        WHERE b.booking_id = $booking_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Booking not found.</div>";
    include('client_footer.php');
    exit();
}

$row = $result->fetch_assoc();

// Amount breakdown
$amount = $row['payment_amount']; // base amount
$tax_amount = 0.13*$amount;
$service_charge = 0.05*$amount;
$delivery_charge = 0;
$total_amount = $amount + $tax_amount + $service_charge + $delivery_charge;

// eSewa test values
$product_code = "EPAYTEST";
$transaction_uuid = 'BOOK' . $booking_id . '_' . uniqid();
$success_url = "http://localhost/1HF/templates/view/client_pay_success.php?q=su";
$fail_url = "http://localhost/1HF/templates/view/client_pay_failed.php?q=fu";
$signed_field_names = "total_amount,transaction_uuid,product_code";

// Generate signature
function generateEsewaSignature($data, $secret_key) {
    $signed_fields = explode(",", $data['signed_field_names']);
    $string_to_sign = "";

    foreach ($signed_fields as $field) {
        $string_to_sign .= $field . "=" . $data[$field] . ",";
    }

    $string_to_sign = rtrim($string_to_sign, ",");
    return base64_encode(hash_hmac('sha256', $string_to_sign, $secret_key, true));
}

$data = [
    "total_amount" => $total_amount,
    "transaction_uuid" => $transaction_uuid,
    "product_code" => $product_code,
    "signed_field_names" => $signed_field_names
];

$secret_key = "8gBm/:&EnhH.1/q"; // eSewa test merchant key
$signature = generateEsewaSignature($data, $secret_key);
?>

<div class="container mt-5">
    <h4>Payment Summary</h4>
    <div class="card p-4">
        <p><strong>Booking ID:</strong> <?= $booking_id ?></p>
        <p><strong>Client Name:</strong> <?= htmlspecialchars($row['uname']) ?></p>
        <p><strong>Service:</strong> <?= htmlspecialchars($row['service_type']) ?></p>
        <p><strong>Amount:</strong> Rs <?= number_format($amount, 2) ?></p>

        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="<?= $amount ?>">
            <input type="hidden" name="tax_amount" value="<?= $tax_amount ?>">
            <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
            <input type="hidden" name="transaction_uuid" value="<?= $transaction_uuid ?>">
            <input type="hidden" name="product_code" value="<?= $product_code ?>">
            <input type="hidden" name="product_service_charge" value="<?= $service_charge ?>">
            <input type="hidden" name="product_delivery_charge" value="<?= $delivery_charge ?>">
            <input type="hidden" name="success_url" value="<?= $success_url ?>">
            <input type="hidden" name="failure_url" value="<?= $fail_url ?>">
            <input type="hidden" name="signed_field_names" value="<?= $signed_field_names ?>">
            <input type="hidden" name="signature" value="<?= $signature ?>">

            <button type="submit" class="btn btn-success">Pay Now with eSewa</button>
        </form>
    </div>
</div>

<?php include('client_footer.php'); ?>
