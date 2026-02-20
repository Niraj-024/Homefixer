<?php
include('admin_sidebar.php');
include("admin_header.php");
include("../controller/db_conn.php");
?>

<?php
if(isset($_POST['deleteuserbtn'])){
    $uname = $_POST['uname'];
    $role = $_GET['role'];
    
    $query = "UPDATE user SET isactive = 0 WHERE uname = '$uname'";

    $result = mysqli_query($conn, $query);
    
    if(!$result){
        die('Status update failed: ' . $conn->error);
    } else {
        if($role == 'admin')
            header('location:admin.php?deletemsg=***User deactivated successfully***');
        elseif($role == 'client')
            header('location:admin_client.php?deletemsg=***User deactivated successfully***');
        elseif($role == 'spr')
            header('location:admin_spr.php?deletemsg=***User deactivated successfully***');
    }        
}
?>
<!-- for service deletion -->
<?php
if(isset($_POST['deleteservicebtn'])){
    $id = $_POST['s_id'];
    $query = "DELETE from service where s_id = '$id' ;" ;
    if($conn->query($query)==false){
        die("Failed delete".$conn->error);
    }else{
        header('location:admin_service.php?deletemsg=***Record deleted successfully***');
    }
}
?>
<?php
include('admin_footer.php');
?>