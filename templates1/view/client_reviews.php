<?php
include ('../controller/session.php');
include('../controller/db_conn.php');
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');

// Create the reviews table if it doesn't exist
$table= "
    CREATE TABLE IF NOT EXISTS reviews (
        review_id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
        comments TEXT,
        review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
    );
";
$conn->query($table);

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Insert the review
    $insert = "INSERT INTO reviews (booking_id, rating, comments) 
               VALUES ('$bookingId', '$rating', '$comments')";
    if ($conn->query($insert) === TRUE) {
        // Update the booking status to 'reviewed'
        $updateStatus = "UPDATE bookings SET status = 'reviewed' WHERE booking_id = '$bookingId'";
        if ($conn->query($updateStatus) === TRUE) {
            echo "<div class='alert alert-success'>Review submitted successfully!</div>";
            echo "<div class='text-center mt-3'>
                    <a href='client_book_history.php' class='btn btn-primary'>Go Back to History</a>
                  </div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating booking status: " . $conn->error . "</div>";
            echo "<div class='text-center mt-3'>
                    <a href='client_book_history.php' class='btn btn-danger'>Go Back to History</a>
                  </div>";
        }        
    } else {
        echo "<div class='alert alert-danger'>Error submitting review: " . $conn->error . "</div>";
    }
}


//for displaying on form
$bookingId = isset($_GET['bid']) ? $_GET['bid'] : '';
$serviceType = isset($_GET['service_type']) ? urldecode($_GET['service_type']) : 'Unknown';
$providerName = isset($_GET['provider_name']) ? urldecode($_GET['provider_name']) : 'Unknown';
?>

<div class="container m-3 border p-3 w-auto h-auto">
    <h2 class="text-center">Leave a Review</h2>
    <p class="text-center text-muted">We value your feedback! Please share your experience.</p>
    <form action="" method="POST">
        <input type="hidden" name="booking_id" value="<?php echo $bookingId?>">
        <div class="mb-3">
            <label for="serviceType" class="form-label">Service Type</label>
            <input type="text" class="form-control" id="serviceType" value="<?php echo $serviceType; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="providerName" class="form-label">Service Provider</label>
            <input type="text" class="form-control" id="providerName" value="<?php echo $providerName; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <select class="form-select" id="rating" name="rating" required>
                <option value="" disabled selected>Choose a rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea class="form-control" id="comments" name="comments" rows="4" placeholder="Share your feedback (optional)"></textarea>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </div>
    </form>
</div>

<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif;
?>
