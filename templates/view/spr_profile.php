<?php 
include ('../controller/session.php');
include ('../controller/db_conn.php');

if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php
if(isset($_SESSION['id']))
$id = $_SESSION['id'];

$query = "SELECT * FROM user WHERE role = 'spr' AND u_id = '$id';";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . $conn->error);
} else {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Check if provider is approved
        if ($row['is_approved'] == '1') {
            include('spr_header.php');
?>
            <div class="profile container overflow-auto">
                <!-- Message section -->
                <span class="bg-success text-light"><?php if(isset($_GET['updatemsg'])){echo $_GET['updatemsg'];}; ?></span>
                <span class="bg-danger"><?php if(isset($_GET['err'])){echo $_GET['err'];}; ?></span>

                <!-- Header Section -->
                <div class="bg-white p-4 rounded shadow-sm text-center">
                    <img src="/1HF/db_images/<?php echo $row['image']; ?>" alt="Profile picture" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                    <h3 class="fw-bold mb-1"><?php echo $row['uname']; ?></h3>
                    <p class="text-muted mb-3">Service Provider</p>
                    <a href="spr_update.php?id=<?php echo $row['u_id']; ?>" class="btn btn-primary btn-sm me-3">Edit Profile</a>
                    <a href="spr_requests.php" class="btn btn-success btn-sm">View requests</a>
                </div>

                <!-- Detailed Information Section -->
                <div class="bg-white p-4 mt-4 rounded shadow-sm">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Provider Details</h5>
                    <p class="mb-2"><strong>Contact:</strong> <?php echo $row['phone']; ?> </p>
                    <p class="mb-2"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p class="mb-2"><strong>Address:</strong> <?php echo $row['address']; ?></p>
                    <p class="mb-0"><strong>Member Since:</strong> <?php echo date('d M Y, h:i A', strtotime($row['created'])); ?></p>
                </div>
            </div>

<?php 
        } else {  
            // If not approved, show waiting message
?>
            <div class="container text-center mt-5">
                <h2 class="text-warning">Approval Pending</h2>
                <p class="text-muted">Your account is under review. Please wait for the admin to approve your registration.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
<?php 
        }
    } else {
        echo '<h6> *** No records found *** </h6>';
    }
}
?>
</body>
</html>

<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; 
?>
