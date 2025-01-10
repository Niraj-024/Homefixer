<?php
session_start();
include('../controller/db_conn.php');

// Make sure the provider ID is available in the session
$provider_id = $_SESSION['id']; // Assuming the provider's ID is stored in session

if (isset($_POST['action']) && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        // Update the booking status and set the provider_id
        $sql = "UPDATE bookings 
                SET status = 'accepted', provider_id = '$provider_id' 
                WHERE booking_id = '$request_id';";
    } else {
        echo "Invalid action";
    }

    if ($conn->query($sql)) {
        header('location: spr_requests.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    echo "Missing required data";
}

// For marking complete
if (isset($_POST['action']) && $_POST['action'] == 'completed') {
    $booking_id = $_POST['booking_id'];
    
    $updateSql = "UPDATE bookings SET status = 'completed' WHERE booking_id = '$booking_id'";
    if ($conn->query($updateSql)) {
        header("Location: spr_book.php");
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>
