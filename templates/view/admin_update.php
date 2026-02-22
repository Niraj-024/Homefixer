<?php
include('admin_sidebar.php');
include("admin_header.php");
include("../controller/db_conn.php");
?>

<!-- ================= USER UPDATE SECTION ================= -->

<?php
if(isset($_GET['name'])){
    $bname = $_GET['name'];
    $role = $_GET['role'];

    $query = "SELECT * FROM user WHERE uname = '$bname'";
    $result = mysqli_query($conn , $query);

    if(!$result){
        die("query failed ".$conn->error);
    } else {
        $row = mysqli_fetch_assoc($result);
    }
?>

<form action="admin_update.php?bname=<?php echo $bname; ?>&role=<?php echo $role; ?>" method="POST">

    <h2 class="bg-secondary">
        Update <?php 
        if($role == 'spr'){
            echo 'Service Provider';
        } else {
            echo $role;
        }
        ?>
    </h2>

    <div class="form-group mt-0">
        <label>Full Name</label>
        <input type="text" name="uname" class="form-control" value="<?php echo $row['uname'];?>">
    </div>

    <div class="form-group">
        <label>Phone Number</label>
        <input type="text" name="phone" maxlength="10" class="form-control" value="<?php echo $row['phone'];?>">
    </div>

    <div class="form-group">
        <label>Address</label>
        <input type="text" name="addr" class="form-control" value="<?php echo $row['address'];?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $row['email'];?>">
    </div>

    <div class="form-group d-flex flex-row-reverse">
        <input type="submit" class="btn btn-success" name="adminupdate" value="Update">
    </div>

</form>

<?php
}

if(isset($_POST['adminupdate'])){

    $bname = $_GET['bname'];
    $name = $_POST['uname'];
    $addr = $_POST['addr'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE user 
              SET uname ='$name', address='$addr', email='$email', phone='$phone'
              WHERE uname='$bname'";

    $result = mysqli_query($conn , $query);

    if(!$result){
        die('Failed Update '.$conn->error);
    } else {

        $role = $_GET['role'];

        if($role == 'admin')
            header('location:admin.php?updatemsg=***Record updated successfully***');
        elseif($role == 'client')
            header('location:admin_client.php?updatemsg=***Record updated successfully***');
        elseif($role == 'spr')
            header('location:admin_spr.php?updatemsg=***Record updated successfully***');
    }
}
?>



<!-- ================= SERVICE UPDATE SECTION ================= -->

<?php
if(isset($_GET['id'])){

    $id = $_GET['id'];
    $query = "SELECT * FROM service WHERE s_id = '$id'";
    $result = mysqli_query($conn , $query);

    if(!$result){
        die("query failed ".$conn->error);
    } else {
        $row = mysqli_fetch_assoc($result);
    }
?>

<form action="admin_update.php?id=<?php echo $id;?>" method="POST" enctype="multipart/form-data">

    <h2 class="bg-secondary">Update Service</h2>

    <div class="form-group mt-0">
        <label>Service Name</label>
        <input type="text" name="sname" class="form-control" required value="<?php echo $row['s_name'];?>">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" required value="<?php echo $row['description'];?>">
    </div>

    <div class="form-group">
        <label>Season</label>
        <select name="season" class="form-control" required>
            <option value="all" <?php if($row['season']=='all') echo 'selected'; ?>>All Season</option>
            <option value="summer" <?php if($row['season']=='summer') echo 'selected'; ?>>Summer</option>
            <option value="winter" <?php if($row['season']=='winter') echo 'selected'; ?>>Winter</option>
            <option value="rainy" <?php if($row['season']=='rainy') echo 'selected'; ?>>Rainy</option>
            <option value="festive" <?php if($row['season']=='festive') echo 'selected'; ?>>Festive</option>
        </select>
    </div>

    <div class="form-group">
        <label>Image</label><br>
        <input type="file" name="file">
        <input type="hidden" name="oldfile" value="<?php echo $row['image'];?>">
    </div>

    <div class="form-group d-flex flex-row-reverse">
        <input type="submit" class="btn btn-success" name="serviceupdate" value="Update">
    </div>

</form>

<?php
}

if(isset($_POST['serviceupdate'])){

    $id = $_GET['id'];
    $name = $_POST['sname'];
    $description = $_POST['description'];
    $season = $_POST['season'];

    $filename = $_FILES['file']['name'];
    $filename_old = $_POST['oldfile'];
    $filetmp = $_FILES['file']['tmp_name'];

    $serviceDir = 'C:/xampp/htdocs/1HF/serviceimg/';

    if($filename !== ''){

        if(!file_exists($serviceDir . $filename)){
            move_uploaded_file($filetmp, $serviceDir . $filename);
        } else {
            header('location:admin_service.php?err=***File already exists***');
            exit();
        }

    } else {
        $filename = $filename_old;
    }

    $query = "UPDATE service 
              SET s_name='$name',
                  description='$description',
                  season='$season',
                  image='$filename'
              WHERE s_id='$id'";

    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Failed Update: " . mysqli_error($conn));
    } else {
        header('location:admin_service.php?updatemsg=***Record Updated Successfully***');
        exit();
    }
}
?>

<?php
include('admin_footer.php');
?>