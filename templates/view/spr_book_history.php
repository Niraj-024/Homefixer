<?php include ('../controller/session.php');
    include ('../controller/db_conn.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');
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

<div class="container m-3 p-3 border w-auto h-auto ">
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
            <!-- Example Completed/Cancelled Order -->
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>Electrical</td>
                <td>2025-01-12 14:00</td>
                <td>456 Oak Ave</td>
                <td><span class="badge bg-success">Completed</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Bob Johnson</td>
                <td>Cleaning</td>
                <td>2025-01-14 09:00</td>
                <td>789 Pine Rd</td>
                <td><span class="badge bg-secondary text-dark">Cancelled</span></td>
            </tr>
        </tbody>
    </table>
</div>



<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>