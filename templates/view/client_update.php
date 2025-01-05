<?php
    include ('../controller/db_conn.php');
    include('client_header.php');
?> 

<?php
//for displaying data

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * from user where u_id = '$id' ; ";
    $result = mysqli_query($conn , $query);
    if(!$result){
        die("query failed".$conn->error);
    }else{
        $row = mysqli_fetch_assoc($result);
    }
}
?>
<div class="crud-section">

    <form action="client_update.php?id=<?php echo $id;?>" method="POST" enctype="multipart/form-data">
        
        <h2 class="bg-secondary">Edit your profile</h2>
        
        <div class="form-group mt-0">
            <label for="sname">Name</label>
            <input type="text" id="sname" name="sname" class="form-control" required value = "<?php echo $row['uname'];?>">
        </div>
        <div class="form-group">
            <label for="phone">Contact</label><br>
            <input type="text" id="phone" name="phone" required  class="form-control" value = "<?php echo $row['phone'];?>">
        </div>
        <div class="form-group">
     <label for="email">Email</label><br>
     <input type="email" id="email" name="email" required  class="form-control" value = "<?php echo $row['email'];?>">
 </div>
 <div class="form-group">
     <label for="address">Address</label><br>
     <input type="text" id="address" name="address" required  class="form-control" value = "<?php echo $row['address'];?>">
 </div>
 <div class="form-group">
     <label for="file">Image</label><br>
     <input type="file" id="file" name="file">
     <input type="hidden" name="oldfile" value="<?php echo $row['image'];?>">
    </div>
    <div class="form-group d-flex flex-row-reverse ">
        <input type="submit" class="btn btn-success " name="client_update" value="Update">
    </div>
    
</form>
</div>

<?php
// FOR updating
if(isset($_POST['client_update'])){
    $name =$_POST['sname'];
    $address =$_POST['address'];
    $email =$_POST['email'];
    $phone =$_POST['phone'];
    $filename =$_FILES['file']['name'];
    $filename_old =$_POST['oldfile'];
    $filetmp = $_FILES['file']['tmp_name'];
    $serviceDir = 'C:/xampp/htdocs/1HF/db_images/';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        // Update the service in the database
        $query = "UPDATE user SET uname = '$name', address = '$address',phone = '$phone',email = '$email', image = '$filename' WHERE u_id = '$id' ;";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die("Failed Update: " . mysqli_error($conn));
        } else {
            if ($filename !== '') {
                if (!file_exists($serviceDir . $filename)) {
                    // Move the new file to the service directory
                    move_uploaded_file($filetmp, $serviceDir . $filename);
                } else {
                    // Redirect if file already exists
                    header('location:client_profile.php?err=***File already exists***');
                    exit();
                }
            } else {
                // Use the old file if no new file is uploaded
                $filename = $filename_old;
            }
            header('location:client_profile.php?updatemsg=***Record Updated Successfully***');
            exit();
        }
    }
}

?>


<?php include('client_footer.php'); ?>