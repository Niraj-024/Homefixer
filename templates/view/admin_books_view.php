<?php
include('admin_sidebar.php');
if ($_SESSION['role'] != 'client' && $_SESSION['role'] != 'spr') {
    include('admin_header.php');
    include('../controller/db_conn.php');

    // Fetch booking details
    if (isset($_GET['id'])) {
        $booking_id =$_GET['id'];
        $query = "SELECT b.*, u.uname, u.email, u.phone, u.address 
                  FROM bookings b 
                  INNER JOIN user u ON b.user_id = u.u_id 
                  WHERE b.booking_id = $booking_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $booking = mysqli_fetch_assoc($result);
        } else {
            echo "<div class='alert alert-danger'>No booking found.</div>";
            echo "<a href='admin_books.php' class='btn btn-secondary'>Back to Bookings</a>";
            include('admin_footer.php');
            exit;
        }
    } else {
        echo "<div class='alert alert-warning'>No booking selected.</div>";
        echo "<a href='admin_books.php' class='btn btn-secondary'>Back to Bookings</a>";
        include('admin_footer.php');
        exit;
    }
?>
<div class="container mt-5">
    <h2>Booking Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Booking ID:</strong> <?= htmlspecialchars($booking['booking_id']) ?></li>
        <li class="list-group-item"><strong>Client Name:</strong> <?= htmlspecialchars($booking['uname']) ?></li>
        <li class="list-group-item"><strong>Service Type:</strong> <?= htmlspecialchars($booking['service_type']) ?></li>
        <li class="list-group-item"><strong>Booking Date:</strong> <?= htmlspecialchars($booking['booking_date']) ?></li>
        <li class="list-group-item"><strong>Service Location:</strong> <?= htmlspecialchars($booking['service_location']) ?></li>
        <li class="list-group-item"><strong>Description:</strong> <?= htmlspecialchars($booking['description']) ?></li>
        <li class="list-group-item"><strong>Contact Details:</strong> <?= htmlspecialchars($booking['contact_details']) ?></li>
        <li class="list-group-item"><strong>Status:</strong> <?= ucfirst(htmlspecialchars($booking['status'])) ?></li>
        <li class="list-group-item"><strong>Created At:</strong> <?= htmlspecialchars($booking['created_at']) ?></li>
        <li class="list-group-item"><strong>Updated At:</strong> <?= htmlspecialchars($booking['updated_at']) ?></li>
    </ul>
    <a href="admin_books.php" class="btn btn-secondary mt-3">Back to Bookings</a>
</div>
<?php
    include('admin_footer.php');
} else {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    include('admin_footer.php');
    exit;
}
?>
