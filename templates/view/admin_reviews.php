<?php
include('admin_sidebar.php');
if ($_SESSION['role'] != 'client' && $_SESSION['role'] != 'spr') {
    include('admin_header.php');
    include('../controller/db_conn.php');

    // Fetch all reviews
    $query = "SELECT r.*, b.service_type, u.uname 
              FROM reviews r 
              INNER JOIN bookings b ON r.booking_id = b.booking_id 
              INNER JOIN user u ON b.user_id = u.u_id
              Where r.status='1'; ";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<div class='alert alert-danger'>Error fetching reviews: " . mysqli_error($conn) . "</div>";
        include('admin_footer.php');
        exit;
    }
?>
<div class="container mt-5">
    <h2>All Reviews</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Client Name</th>
                    <th>Service Type</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Review Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['review_id']) ?></td>
                        <td><?= htmlspecialchars($review['uname']) ?></td>
                        <td><?= htmlspecialchars($review['service_type']) ?></td>
                        <td><?= htmlspecialchars($review['rating']) ?></td>
                        <td><?= htmlspecialchars($review['comments']) ?></td>
                        <td><?= htmlspecialchars($review['review_date']) ?></td>
                        <td>
                            <a href="admin_book_delete.php?review_id=<?= htmlspecialchars($review['review_id']) ?>" 
                               class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No reviews found.</div>
    <?php endif; ?>
</div>
<?php
    include('admin_footer.php');
} else {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    include('admin_footer.php');
    exit;
}
?>
