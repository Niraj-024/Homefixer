<?php include ('../controller/session.php');
    include ('../controller/db_conn.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');
?>

<!-- Service Requests Table -->
<div class="container m-3 p-3 border w-auto h-auto ">
    <h5>Service Requests - Pending</h5>

    <table class="table table-hover table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Request ID</th>
                <th>Client Name</th>
                <th>Service Type</th>
                <th>Date/Time</th>
                <th>Location</th>
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
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="loadRequestInfo(1)">View</button>
                        <button class="btn btn-sm btn-danger" onclick="rejectRequest()">Reject</button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="acceptRequest()">Accept</button>
                <button type="button" class="btn btn-danger" onclick="rejectRequest()">Reject</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to load the request info into the modal
    function loadRequestInfo(requestId) {
        // Example: Dynamically load data into the modal
        document.getElementById("requestId").innerText = requestId;
        document.getElementById("clientName").innerText = "John Doe";
        document.getElementById("serviceType").innerText = "Plumbing";
        document.getElementById("requestDate").innerText = "2025-01-10 10:00";
        document.getElementById("location").innerText = "123 Main St";
        document.getElementById("description").innerText = "Leaking faucet in the kitchen.";
    }

    // Function to accept the request
    function acceptRequest() {
        // Action for accepting the request
        alert("Request Accepted!");

        // Close the modal
        $('#viewModal').modal('hide');
    }

    // Function to reject the request
    function rejectRequest() {
        // Action for rejecting the request
        alert("Request Rejected!");

        // Close the modal
        $('#viewModal').modal('hide');
    }
</script>



<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>