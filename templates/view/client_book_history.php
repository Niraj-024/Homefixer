<?php 
include ('../controller/session.php');
include('../controller/db_conn.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
    $id = $_SESSION['id'];

    $sql ="SELECT b.*, u.uname 
    FROM bookings b
    LEFT JOIN user u ON b.provider_id = u.u_id
    WHERE b.user_id = '15' AND (b.status = 'completed' OR b.status = 'cancelled' OR b.status = 'reviewed')
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
        <td><?php echo $row['service_type']; ?></td>
        <td><?php echo $row['booking_date']; ?></td>
        <td><?php echo $row['service_location']; ?></td>
        <td><?php echo $row['uname'] ? $row['uname'] : 'N/A'; ?></td>
        <td>
            <?php 
                if ($row['status'] == 'completed') {
                    echo "<span class='badge bg-success'>Completed</span>";
                }
                elseif ($row['status'] == 'reviewed') {
                    echo "<span class='badge bg-success'>Reviewed</span>";
                } elseif ($row['status'] == 'cancelled') {
                    echo "<span class='badge bg-danger'>Cancelled</span>";
                }
            ?>
        </td>
        <td>
            <?php 
                if ($row['status'] == 'completed') {
                    $bookingId = $row['booking_id'];
                    $serviceType = urlencode($row['service_type']);
                    $providerName = urlencode($row['uname']);
                    echo "<a href='client_reviews.php?bid={$bookingId}&service_type={$serviceType}&provider_name={$providerName}' class='btn btn-sm btn-primary'>Leave a Review</a>";
                } 
            ?>
        </td>

    </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='7'>No history available</td></tr>";
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
endif; ?>