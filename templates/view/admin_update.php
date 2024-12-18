<?php
include('admin_sidebar.php');
include("admin_header.php");
include("../controller/db_conn.php");
?>

<!-- for all users -->
<?php //for displaying data
if(isset($_GET['name'] )){
    $bname = $_GET['name'];
    $role =$_GET['role'];
    $query = "SELECT * from user where uname = '$bname' ; ";
    $result = mysqli_query($conn , $query);
    if(!$result){
        die("query failed".$conn->error);
    }else{
        $row = mysqli_fetch_assoc($result);
    }
    ?>          


<form action="admin_update.php?bname=<?php echo $bname; ?>&role=<?php echo $role; ?>" method="POST" enctype="multipart/form-data">

    <h2 class="bg-secondary">Update <?php 
    if($role == 'spr'){
        $spr = 'Service Provider';
        echo $spr;
    }else{  echo $role; }?>
    </h2>

    <div class="form-group mt-0">
        <label for="uname">Full Name</label>
        <input type="text" id="uname" name="uname" class="form-control" value = "<?php echo $row['uname'];?>">
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone"  maxlength="10" class="form-control" value = "<?php echo $row['phone'];?>">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="addr"  rows="1" class="form-control" value = "<?php echo $row['address'];?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value = "<?php echo $row['email'];?>"  >
    </div>
    <div class="form-group d-flex flex-row-reverse ">
    <input type="submit" class="btn btn-success " name="adminupdate" value="Update">
    </div>

</form>


<?php 
} //for updating 
if(isset($_POST['adminupdate'])){

    if(isset($_GET['bname'])){
        $bname = $_GET['bname'];
    }

    $name = $_POST['uname'];
    $addr = $_POST['addr'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE user set uname ='$name', address = '$addr', email ='$email' , phone = '$phone' WHERE uname = '$bname';"; //update here
    $result = mysqli_query($conn , $query);
    if(!$result){
        die('Failed Update' . $conn->error);
    }else{
        if(isset($_GET['role'])){
            $role = $_GET['role'];

            if($role == 'admin')
            header('location:admin.php?updatemsg=***Recoed updated successfully***');
            elseif($role == 'client')
            header(('location:admin_client.php?updatemsg=***Record updated successfully***'));
            elseif($role == 'spr')
            header(('location:admin_spr.php?updatemsg=***Record updated successfully***'));
        }
    }
}

?>


<!-- *****************for service update************ -->
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * from service where s_id = '$id' ; "; //for displaying in update form
    $result = mysqli_query($conn , $query);
    if(!$result){
        die("query failed".$conn->error);
    }else{
        $row = mysqli_fetch_assoc($result);
    }
?>


<form action="admin_update.php?id=<?php echo $id;?>" method="POST" enctype="multipart/form-data">
 
    <h2 class="bg-secondary">Update Service</h2>

    <div class="form-group mt-0">
        <label for="sname">Service Name</label>
        <input type="text" id="sname" name="sname" class="form-control" required value = "<?php echo $row['s_name'];?>">
    </div>
    <div class="form-group">
        <label for="caption">Caption</label><br>
        <input type="text" id="caption" name="caption" required  class="form-control" value = "<?php echo $row['caption'];?>">
    </div>
    <div class="form-group">
        <label for="file">Image</label><br>
        <input type="file" id="file" name="file">
        <input type="hidden" name="oldfile" value="<?php echo $row['image'];?>">
    </div>
    <div class="form-group d-flex flex-row-reverse ">
    <input type="submit" class="btn btn-success " name="serviceupdate" value="Update">
    </div>

</form>


<?php
}
if(isset($_POST['serviceupdate'])){
    $name =$_POST['sname'];
    $caption =$_POST['caption'];
    $filename =$_FILES['file']['name'];
    $filename_old =$_POST['oldfile'];
    $filetmp = $_FILES['file']['tmp_name'];
    $serviceDir = 'C:/xampp/htdocs/1HF/serviceimg/';
    if(isset($_GET['id'])){
        if ($filename !== '') {
            if (!file_exists($serviceDir . $filename)) {
                // Move the new file to the service directory
                move_uploaded_file($filetmp, $serviceDir . $filename);
            } else {
                // Redirect if file already exists
                header('location:admin_service.php?err=***File already exists***');
                exit();
            }
        } else {
            // Use the old file if no new file is uploaded
            $filename = $filename_old;
        }

        // Update the service in the database
        $query = "UPDATE service SET s_name = '$name', caption = '$caption', image = '$filename' WHERE s_id = '$id';";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Failed Update: " . mysqli_error($conn));
        } else {
            header('location:admin_service.php?updatemsg=***Record Updated Successfully***');
            exit();
        }
    }
}

    
?>

<?php
include('admin_footer.php');
?>