<?php
include ('../controller/session.php');
include('../controller/db_conn.php');
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
    $id = $_SESSION['id'];

    // Fetch all reviews by the logged-in user
    $sql = "SELECT r.*, b.service_type, b.booking_date, u.uname 
            FROM reviews r
            INNER JOIN bookings b ON r.booking_id = b.booking_id
            INNER JOIN user u ON b.provider_id = u.u_id
            WHERE b.user_id = '$id' 
            ORDER BY r.review_date DESC;";

    $result = $conn->query($sql);
?>  

<div class="container m-3 p-3 border w-auto h-auto">
    <h5 class="text-center">My Reviews</h5>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-hover table-bordered mt-3 table-responsive">
            <thead class="table-secondary">
                <tr>
                    <th>SN</th>
                    <th>Service Type</th>
                    <th>Provider</th>
                    <th>Date</th>
                    <th>Rating</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = 0;
                while ($row = $result->fetch_assoc()):
                    $sn++;
                ?>
                <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['service_type']; ?></td>
                    <td><?php echo ($row['uname']); ?></td>
                    <td><?php echo date('d M Y, h:i A', strtotime($row['review_date'])); ?></td>
                    <td><?php echo str_repeat('⭐', $row['rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['comments']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">You have not submitted any reviews yet.</div>
    <?php endif; ?>
</div>

<?php include('client_footer.php'); ?>

<?php 
elseif ($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif ($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; 
?>
