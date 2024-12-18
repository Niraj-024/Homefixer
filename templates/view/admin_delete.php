<?php
include('admin_sidebar.php');
include("admin_header.php");
include("../controller/db_conn.php");
?>


<?php
// if(isset($_GET['name'])){
//     $dname = $_GET['name'];
//     $role = $_GET['role'];
// $query = "DELETE from user where uname = '$dname' ;" ;
// $result = mysqli_query($conn , $query);

// if(!$result){
//     die('Delete failed'. $conn-> error);
// }else{
//     if($role == 'admin')
//     header('location:admin.php?deletemsg=***Record deleted successfully***');
//     elseif($role == 'client')
//     header(('location:admin_client.php?deletemsg=***Record deleted successfully***'));
//     elseif($role == 'spr')
//     header(('location:admin_spr.php?deletemsg=***Record deleted successfully***'));

// } 
// }
if(isset($_POST['deleteuserbtn'])){
    $uname= $_POST['uname'];
    $role = $_GET['role'];
    $query = "DELETE from user where uname = '$uname' ;" ;

    $result = mysqli_query($conn , $query);
    if(!$result){
        die('Delete failed'. $conn-> error);
        }else{
        if($role == 'admin')
        header('location:admin.php?deletemsg=***Record deleted successfully***');
        elseif($role == 'client')
        header(('location:admin_client.php?deletemsg=***Record deleted successfully***'));
        elseif($role == 'spr')
        header(('location:admin_spr.php?deletemsg=***Record deleted successfully***'));
    }        
}
?>


<!-- for service deletion -->
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
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