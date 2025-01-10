<?php
session_start();
include('../controller/db_conn.php');

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr') {
    include('client_header.php');
    $id = $_SESSION['id'];

    // Fetch bookings with provider info
    $sql = "SELECT b.*, u.uname AS provider_name 
            FROM bookings b 
            LEFT JOIN user u ON b.provider_id = u.u_id 
            WHERE b.user_id ='$id' AND b.status IN ('pending', 'accepted');";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error fetching bookings: " . $conn->error);
    }

    // Fetch booking images
    $bookingImages = [];
    $imagesQuery = "SELECT booking_id, image_path FROM booking_images WHERE booking_id IN (SELECT booking_id FROM bookings WHERE user_id = '$id');";
    $imagesResult = $conn->query($imagesQuery);
    if ($imagesResult && $imagesResult->num_rows > 0) {
        while ($imageRow = $imagesResult->fetch_assoc()) {
            $bookingImages[$imageRow['booking_id']][] = $imageRow['image_path'];
        }
    }
?>
<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="client_booknew.php">Book New Service</a></li>
        <li class="nav-item"><a class="nav-link active" href="client_book_current.php">My Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="client_book_history.php">History</a></li>
    </ul>
</div>

<div class="container m-3 border p-3 w-auto h-auto">
    <h5>Current Bookings</h5>
    <?php if (isset($_GET['cancel'])) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        The booking has been cancelled successfully!!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <table class="table table-hover table-bordered mt-3 table-responsive">
        <thead class="table-secondary">
            <tr>
                <th>SN</th>
                <th>Service Type</th>
                <th>Date/Time</th>
                <th>Location</th>
                <th>Status</th>
                <th>Provider</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sn = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['bid'] = $row['booking_id'];
        ?>
            <tr>
                <td><?php echo ++$sn; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['service_location']; ?></td>
                <td>
                    <?php if ($row['status'] == 'pending') {
                        echo "<span class='badge bg-warning text-dark'>Pending</span>";
                    } elseif ($row['status'] == 'accepted') {
                        echo "<span class='badge bg-success'>Accepted</span>";
                    } ?>
                </td>
                <td>
                    <?php if ($row['status'] == 'accepted') {
                        echo $row['provider_name'] ? $row['provider_name'] : 'Provider not assigned';
                    } else {
                        echo '-';
                    } ?>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['booking_id']; ?>">View</button>
                        <?php if ($row['status'] == 'pending') { ?>
                        <form onsubmit="return confirm('Do you sure want to cancel?')" action="client_book_process.php" method="POST">
                            <button class="btn btn-sm btn-danger" type="submit">Cancel</button>
                        </form>
                        <?php } else { ?>
                        <button class="btn btn-sm btn-light" onclick="alert('Cannot be cancelled after acceptance');">Cancel</button>
                        <?php } ?>
                    </div>
                </td>
            </tr>

            <!-- Modal for Viewing Request Details -->
            <div class="modal fade" id="viewModal<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $row['booking_id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel<?php echo $row['booking_id']; ?>">Booking Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Service Type:</strong> <?php echo $row['service_type']; ?></p>
                            <p><strong>Preferred Date/Time:</strong> <?php echo $row['booking_date']; ?></p>
                            <p><strong>Location:</strong> <?php echo $row['service_location']; ?></p>
                            <p><strong>Contact:</strong> <?php echo $row['contact_details']; ?></p>
                            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                            <p><strong>Images:</strong></p>
                            <div class="d-flex flex-wrap gap-1">
                                <?php
                                if (!empty($bookingImages[$row['booking_id']])) {
                                    foreach ($bookingImages[$row['booking_id']] as $image) {
                                        echo "<img src='/1HF/booking_images/$image' class='img-thumbnail' style='max-width: 220px; border:1px solid grey'>";
                                    }
                                } else {
                                    echo "<p>No images available.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<tr><td colspan='7'>**No bookings found.**</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php include('client_footer.php'); ?>
<?php
} elseif ($_SESSION['role'] == 'spr') {
    header("location: spr_profile.php");
} elseif ($_SESSION['role'] == 'admin') {
    header("location: admin.php");
}
?>
