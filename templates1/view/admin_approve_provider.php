<?php
include('../controller/db_conn.php');
if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];
    $sql = "UPDATE user SET is_approved = 1 WHERE u_id = $provider_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_unapproved_spr.php?msg=Provider approved successfully");
    } else {
        echo "Error updating record: " . $conn->error;
    }   
}
?>
