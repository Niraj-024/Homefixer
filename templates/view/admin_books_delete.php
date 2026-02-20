<?php
include('../controller/db_conn.php');


//for deleting booking info
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $id = $_POST['booking_id'];

    $query = "DELETE FROM bookings WHERE booking_id = $id";
    if (mysqli_query($conn, $query)) {
        header("location: admin_books.php?msg=Booking deleted successfully");
    } else {
        header("location: admin_books.php?msg=Failed to delete booking");
    }
} else {
    header("location: admin_books.php");
}

//for deleting reviews
if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];

    // Check if the review exists
    $query = "SELECT * FROM reviews WHERE review_id = $review_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $update_query = "UPDATE reviews SET status = 0 WHERE review_id = $review_id";
        if (mysqli_query($conn, $update_query)) {
            echo "<div class='alert alert-success'>Review deactivated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deactivating review: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Review not found.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No review ID specified.</div>";
}

echo "<a href='admin_reviews.php' class='btn btn-secondary mt-3'>Back to Reviews</a>";

?>