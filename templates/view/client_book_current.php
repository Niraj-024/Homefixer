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
            <a class="nav-link active" href="client_book_current.php">My Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="client_book_history.php">History</a>
        </li>
    </ul>
</div>

<div class="container m-3 border p-3 w-auto h-auto">
    <h5>Current Bookings</h5>
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
            <!-- Example Row -->
            <tr>
                <td>1</td>
                <td>Plumbing</td>
                <td>2025-01-10 14:00</td>
                <td>123 Main Street</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td>-</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" >View</button>
                        <button class="btn btn-sm btn-danger" >Cancel</button>
                    </div>
                </td>
            </tr>
            <tr>  
                <td>2</td>
                <td>Cleaning</td>
                <td>2025-01-12 10:00</td>
                <td>456 Elm Street</td>
                <td><span class="badge bg-success">Accepted</span></td>
                <td>John Doe (9876543210)</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary">View</button>
                        <button class="btn btn-light btn-sm " onclick="alert('Cannot be cancelled after acceptance');"> Cancel</button>
                    </div>
                </td>
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