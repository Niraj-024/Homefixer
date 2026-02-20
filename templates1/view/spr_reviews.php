<?php include('../controller/session.php');
include('../controller/db_conn.php');
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');

    $providerId = $_SESSION['id'];
    $sql = "
        SELECT r.review_date, r.rating, r.comments, b.service_type, b.booking_date, u.uname AS client_name
        FROM reviews r
        JOIN bookings b ON r.booking_id = b.booking_id
        JOIN user u ON b.user_id = u.u_id
        WHERE b.provider_id = '$providerId'
        ORDER BY r.review_date DESC
    ";
    $result = $conn->query($sql);
?>

    <div class="container m-3 p-3 border w-auto h-auto ">
        <h3 class="text-center">Reviews from your clients</h3>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>SN</th>
                        <th>Client Name</th>
                        <th>Service Type</th>
                        <th>Booking Date</th>
                        <th>Review Date</th>
                        <th>Rating</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $sn = 0;
                        while ($row = $result->fetch_assoc()) {
                            $sn++;
                            $ratingStars = str_repeat('⭐', $row['rating']);
                            echo "<tr> 
                                    <td>$sn</td>
                                    <td>{$row['client_name']}</td>
                                    <td>{$row['service_type']}</td>
                                    <td>" . date('d M Y, h:i A', strtotime($row['booking_date'])) . "</td>
                                    <td>" . date('d M Y, h:i A', strtotime($row['review_date'])) . "</td>
                                    <td>{$ratingStars}</td>
                                    <td>" . nl2br($row['comments']) . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No reviews available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>



    <?php include('client_footer.php'); ?>

<?php
elseif ($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif ($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>