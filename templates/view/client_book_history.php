<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
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
            </tr>
        </thead>
        <tbody>
            <!-- Example Row -->
            <tr>
                <td>1</td>
                <td>Electrical</td>
                <td>2025-01-05 09:00</td>
                <td>789 Maple Street</td>
                <td>Jane Doe (1234567890)</td>
                <td><span class="badge bg-success">Completed</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Plumbing</td>
                <td>2025-01-03 15:00</td>
                <td>123 Main Street</td>
                <td>-</td>
                <td><span class="badge bg-danger">Cancelled</span></td>
            </tr>
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