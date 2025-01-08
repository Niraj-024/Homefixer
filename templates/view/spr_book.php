<?php include ('../controller/session.php');
    include ('../controller/db_conn.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');
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

<div class="container m-3 p-3 border w-auto h-auto ">
    <h5>Active Orders- in progress</h5>

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
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>Plumbing</td>
                <td>2025-01-10 10:00</td>
                <td>123 Main St</td>
                <td><span class="badge bg-warning text-dark">In Progress</span></td>
                <td>
                    <div class="d-flex gap-3">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="loadBookingInfo(1)">View</button>
                        <!-- this button needs js -->
                        <button class="btn btn-sm btn-success">Mark completed</button> 
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<!-- Modal for Viewing Request Details -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Service Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Request ID:</strong> <span id="requestId">1</span></p>
                <p><strong>Client Name:</strong> <span id="clientName">John Doe</span></p>
                <p><strong>Service Type:</strong> <span id="serviceType">Plumbing</span></p>
                <p><strong>Preferred Date/Time:</strong> <span id="requestDate">2025-01-10 10:00</span></p>
                <p><strong>Location:</strong> <span id="location">123 Main St</span></p>
                <p><strong>Contact:</strong> <span id="phone">9877445566</span></p>
                <p><strong>Description:</strong> <span id="description">Leaking faucet in the kitchen.</span></p>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to load the request info into the modal
    function loadBookingInfo(requestId) {
        // Example: Dynamically load data into the modal
        document.getElementById("requestId").innerText = requestId;
        document.getElementById("clientName").innerText = "John Doe";
        document.getElementById("serviceType").innerText = "Plumbing";
        document.getElementById("requestDate").innerText = "2025-01-10 10:00";
        document.getElementById("location").innerText = "123 Main St";
        document.getElementById("description").innerText = "Leaking faucet in the kitchen.";
    }
</script>


<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>