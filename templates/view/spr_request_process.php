<?php
session_start();
include('../controller/db_conn.php');

// Provider ID from session
$provider_id = $_SESSION['id'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Accept booking
    if ($action == 'accept' && isset($_POST['request_id'])) {
        $request_id = (int)$_POST['request_id'];

        // Accept booking only if unassigned
        $sql = "UPDATE bookings 
                SET status = 'accepted', provider_id = '$provider_id' 
                WHERE booking_id = '$request_id' AND provider_id IS NULL";

        if ($conn->query($sql)) {
            header('Location: spr_requests.php');
            exit();
        } else {
            echo "Error accepting booking: " . $conn->error;
            exit();
        }

    // Complete booking with amount
    } elseif ($action == 'completed' && isset($_POST['booking_id'])) {
        $booking_id = (int)$_POST['booking_id'];
        $payment_amount = isset($_POST['payment_amount']) ? (float)$_POST['payment_amount'] : 0;

        // Update booking: mark completed and save amount
        $stmt = $conn->prepare("UPDATE bookings SET status = 'completed', payment_amount = ? WHERE booking_id = ?");
        $stmt->bind_param("di", $payment_amount, $booking_id);

        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Booking marked as completed and amount set successfully.";
            header("Location: spr_book.php");
            exit();
        } else {
            echo "Error updating booking: " . $stmt->error;
            exit();
        }

        $stmt->close();

    } else {
        echo "Invalid action or missing data";
        exit();
    }
} else {
    echo "No action provided";
    exit();
}
?>