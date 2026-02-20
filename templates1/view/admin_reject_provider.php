<?php
include('../controller/db_conn.php');
if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];
    $sql = "UPDATE user SET is_approved = 2 WHERE u_id = $provider_id"; // Optionally use 2 for rejected
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_unapproved_spr.php?msg=Provider rejected successfully");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
