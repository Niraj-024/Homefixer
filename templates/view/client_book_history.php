<?php
include('../controller/session.php');
include('../controller/db_conn.php');

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
    $id = $_SESSION['id'];

    // Fetch bookings for this client
    $sql = "SELECT b.*, u.uname 
            FROM bookings b
            LEFT JOIN user u ON b.provider_id = u.u_id
            WHERE b.user_id = '$id' 
              AND (b.status IN ('completed','cancelled','reviewed','paid'))
            ORDER BY b.booking_date DESC;";
    $result = $conn->query($sql);
?>
<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="client_booknew.php">Book New Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="client_book_current.php">My Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="client_book_history.php">History</a>
        </li>
    </ul>
</div>

<div class="container m-3 p-3 border w-auto h-auto ">
    <h5>Past Bookings</h5>
    <table class="table table-hover table-bordered mt-3 table-responsive">
        <thead class="table-secondary">
            <tr>
                <th>SN</th>
                <th>Service Type</th>
                <th>Date/Time</th>
                <th>Location</th>
                <th>Provider</th>
                <th>Status</th>
                <th>Amount Paid</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
<?php 
if ($result->num_rows > 0) {
    $sn = 0;
    while ($row = $result->fetch_assoc()) {
        $sn++;
?>
    <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
        <td><?php echo htmlspecialchars($row['service_location']); ?></td>
        <td><?php echo $row['uname'] ? htmlspecialchars($row['uname']) : 'N/A'; ?></td>
        <td>
            <?php 
                switch ($row['status']) {
                    case 'completed':
                        echo "<span class='badge bg-warning text-dark'>Completed</span>";
                        break;
                    case 'paid':
                        echo "<span class='badge bg-success'>Paid</span>";
                        break;
                    case 'reviewed':
                        echo "<span class='badge bg-success'>Reviewed</span>";
                        break;
                    case 'cancelled':
                        echo "<span class='badge bg-danger'>Cancelled</span>";
                        break;
                }
            ?>
        </td>
        <td>
            <?php 
                if ($row['status'] == 'paid' || $row['status'] == 'reviewed') {
                    echo "Rs " . number_format($row['payment_amount'], 2);
                } elseif ($row['status'] == 'completed') {
                    echo "Rs " . number_format($row['payment_amount'], 2) . " (Pending)";
                } else {
                    echo "-";
                }
            ?>
        </td>
        <td>
            <?php 
                if ($row['status'] == 'completed') {
                    $bookingId = $row['booking_id'];
                    echo "<a href='client_book_pay.php?booking_id={$bookingId}' class='btn btn-sm btn-primary'>Pay Now</a>";
                } elseif ($row['status'] == 'paid') {
                    $bookingId = $row['booking_id'];
                    echo "<a href='client_reviews.php?bid={$bookingId}&service_type=" . urlencode($row['service_type']) . "&provider_name=" . urlencode($row['uname']) . "' class='btn btn-sm btn-primary'>Leave Review</a>";
                } else {
                    echo "-";
                }
            ?>
        </td>
    </tr>
<?php
    }
} else {
    echo "<tr><td colspan='8'>No history available</td></tr>";
}
?>
        </tbody>
    </table>
</div>

<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; 
?>