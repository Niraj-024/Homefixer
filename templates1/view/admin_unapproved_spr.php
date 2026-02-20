<?php
include('admin_sidebar.php');
if ($_SESSION['role'] != 'client' && $_SESSION['role'] != 'spr') :
    include('admin_header.php');
    include('../controller/db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unapproved Service Providers</title>
</head>
<body>
<h2>Unapproved Service Providers</h2>
<a href="admin_spr.php" class="btn btn-secondary mt-3">Go Back</a>


<?php
// Fetch all unapproved service providers (where 'is_approved' = 0)
$query = "SELECT * FROM user WHERE role = 'spr' AND is_approved = 0";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
} else {
if (isset($_GET['msg'])) {
    echo "<div class='alert alert-success'>" . $_GET['msg'] . "</div>";
}

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-hover table-bordered table-striped'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['u_id'] . "</td>
                    <td>" . $row['uname'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['created'] . "</td>
                    <td>
                        <a href='admin_approve_provider.php?id=" . $row['u_id'] . "' class='btn btn-success'>Approve</a>
                        <a href='admin_reject_provider.php?id=" . $row['u_id'] . "' class='btn btn-danger'>Reject</a>
                    </td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No new providers request found.</p>";
    }
}
?>

</body>
</html>
<?php include('admin_footer.php'); ?>

<?php 
elseif ($_SESSION['role'] == 'spr'):
    header("location: service provider.php");
elseif ($_SESSION['role'] == 'client'):
    header("location: client.php");
endif;
?>
