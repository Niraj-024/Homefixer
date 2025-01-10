<?php
include('../controller/session.php');
include('../controller/db_conn.php');

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');

    // Fetch all accepted service requests, including images in one query
    $sql = "SELECT b.*, u.uname, 
                (SELECT GROUP_CONCAT(bi.image_path) 
                 FROM booking_images bi 
                 WHERE bi.booking_id = b.booking_id) AS images
            FROM bookings b 
            JOIN user u ON b.user_id = u.u_id 
            WHERE b.status = 'accepted';";
    $result = $conn->query($sql);

?>

<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" href="spr_book.php">Active services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="spr_book_history.php">History</a>
        </li>
    </ul>
</div>

<div class="container m-3 p-3 border w-auto h-auto">
    <h5>Active Orders - Accepted</h5>

    <table class="table table-hover table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Booking ID</th>
                <th>Client Name</th>
                <th>Service Type</th>
                <th>Date/Time</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Explode images to array
                    $images = !empty($row['images']) ? explode(',', $row['images']) : [];
            ?>
                    <tr>
                        <td><?php echo ++$sn; ?></td>
                        <td><?php echo htmlspecialchars($row['uname']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_location']); ?></td>
                        <td><span class="badge bg-warning text-dark">Accepted</span></td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- View Button - Opens Modal -->
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['booking_id']; ?>">View</button>
                                <!-- Mark Completed Button -->
                                <form action="spr_request_process.php" method="POST" class="d-inline">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                    <button type="submit" name="action" value="completed" class="btn btn-sm btn-success">Mark Completed</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal for Viewing Request Details -->
                    <div class="modal fade" id="viewModal<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $row['booking_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel<?php echo $row['booking_id']; ?>">Service Request Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Request ID:</strong> <?php echo $row['booking_id']; ?></p>
                                    <p><strong>Client Name:</strong> <?php echo htmlspecialchars($row['uname']); ?></p>
                                    <p><strong>Service Type:</strong> <?php echo htmlspecialchars($row['service_type']); ?></p>
                                    <p><strong>Preferred Date/Time:</strong> <?php echo htmlspecialchars($row['booking_date']); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['service_location']); ?></p>
                                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact_details']); ?></p>
                                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                    <p><strong>Images:</strong></p>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php
                                        if (!empty($images)) {
                                            foreach ($images as $image) {
                                                echo "<img src='/1HF/booking_images/" . htmlspecialchars($image) . "' class='img-fluid m-1' style='max-width: 220px; border:1px solid grey'>";
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
                echo "<tr><td colspan='7'>No active service requests found.</td></tr>";
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
