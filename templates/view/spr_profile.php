<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('client_header.php');
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to homepage</title>
</head>

<div class="profile container overflow-auto">
    <!-- Header Section -->
    <div class="bg-white p-4 rounded shadow-sm   text-center">
        <img src="../css/img/user.png" alt="Profile picture" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
        <h3 class="fw-bold mb-1">Client Name</h3>
        <p class="text-muted mb-3">Service Provider</p>
        <a href="/edit-profile" class="btn btn-primary btn-sm me-3">Edit Profile</a>
        <a href="client_services.php" class="btn btn-success btn-sm">Orders</a>
    </div>

    <!-- Detailed Information Section -->
    <div class="bg-white p-4 mt-4 rounded shadow-sm">
        <h5 class="fw-bold border-bottom pb-2 mb-3">Provider Details</h5>
        <p class="mb-2"><strong>Contact:</strong> +1 123-456-7890</p>
        <p class="mb-2"><strong>Email:</strong> spr@example.com</p>
        <p class="mb-2"><strong>Address:</strong> 123 Main Street, City, Country</p>
        <p class="mb-0"><strong>Member Since:</strong> January 2022</p>
    </div>

</div>

</html>

<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>