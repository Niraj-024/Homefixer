<?php
include('admin_sidebar.php');
if ($_SESSION['role'] != 'client' && $_SESSION['role'] != 'spr') :
    include('admin_header.php');
    include('../controller/db_conn.php');

    // Fetch all bookings with user details only
    $query = "SELECT 
                b.booking_id, 
                u.uname AS client_name, 
                b.service_type, 
                b.booking_date, 
                b.service_location, 
                b.status 
              FROM bookings b
              JOIN user u ON b.user_id = u.u_id";
    $result = mysqli_query($conn, $query);
?>
    <div class="container mt-4">
        <h2 class="mb-4">All Bookings</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Client Name</th>
                    <th>Service Type</th>
                    <th>Booking Date</th>
                    <th>Service Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['client_name']; ?></td>
                            <td><?php echo $row['service_type']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['service_location']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td>
                                <!-- View Button -->
                                <a href="admin_books_view.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                
                                <!-- Delete Form -->
                                <form method="POST" action="admin_books_delete.php" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
else :
    if ($_SESSION['role'] == 'spr') :
        header("location: service_provider.php");
    elseif ($_SESSION['role'] == 'client') :
        header("location: client.php");
    endif;
endif;
?>
