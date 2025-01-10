<?php
include('../controller/session.php');
include('../controller/db_conn.php');

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');
    
    $id = $_SESSION['id']; // provider's ID

    // SQL query to fetch completed or cancelled bookings for the specific provider
    $sql_history = "SELECT b.*, u.uname, 
                        (SELECT GROUP_CONCAT(bi.image_path) 
                         FROM booking_images bi 
                         WHERE bi.booking_id = b.booking_id) AS images
                   FROM bookings b
                   JOIN user u ON b.user_id = u.u_id
                   WHERE b.provider_id = '$id' AND (b.status = 'completed' OR b.status = 'cancelled')
                   ORDER BY b.booking_id DESC;"; // Fetch history in descending order of booking ID
    $result_history = $conn->query($sql_history);

    if (!$result_history) {
        die("Error fetching history: " . mysqli_error($conn));
    }
?>

<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="spr_book.php">Active services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="spr_book_history.php">History</a>
        </li>
    </ul>
</div>

<div class="container m-3 p-3 border w-auto h-auto">
    <h5>History</h5>
    <table class="table table-hover table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Booking ID</th>
                <th>Client Name</th>
                <th>Service Type</th>
                <th>Date/Time</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = 0;
            if ($result_history->num_rows > 0) {
                while ($row = $result_history->fetch_assoc()) {
                    if ($row['status'] == 'completed') {
                        $status_text = 'Completed';
                        $badge_class = 'bg-success';
                    } else {
                        $status_text = 'Cancelled';
                        $badge_class = 'bg-secondary text-dark';
                    }
            ?>
                    <tr>
                        <td><?php echo ++$sn; ?></td>
                        <td><?php echo htmlspecialchars($row['uname']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_location']); ?></td>
                        <td><span class="badge <?php echo $badge_class; ?>"><?php echo $status_text; ?></span></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No completed or cancelled requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('client_footer.php'); ?>

<?php
elseif ($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif ($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif;
?>
