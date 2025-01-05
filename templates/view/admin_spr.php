<?php
include('admin_sidebar.php');
if($_SESSION['role'] != 'client' && $_SESSION['role'] != 'spr'):
    include('admin_header.php');
    include('../controller/db_conn.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Service Provider</title>
</head>
<body>
<h2>Manage Service Providers</h2>
<div class="mb-10">
    <button class="btn btn-primary float-end mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >Add New Provider</button>
</div>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
           <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Created on</th>
            <th class="d-flex justify-content-center " >Action</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $query = 'SELECT * from user where role = "spr"; ';
        $result = mysqli_query($conn , $query);

        if(!$result){
            die("query failed".$conn->error);
        }else{
            if(mysqli_num_rows($result)>0){
              $count =1;
                while($row = mysqli_fetch_assoc($result)){
        ?>
                <tr>
                    <td><?php echo $count++; ?> </td>
                    <td><?php echo $row['uname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td class="d-flex justify-content-around ">
                        <a href="admin_update.php?name=<?php echo $row['uname'];?>&role=spr" class="btn btn-primary">Update</a>
                        <button class="btn btn-danger delete-btn" type="button" value="<?php echo $row['uname']; ?>">Delete</button>
                    </td> 
                </tr>

        <?php
                }
            }else{
                echo '<h6> ***NO records found*** </h6>';
            }
        }
             ?>
    </tbody>
<?php
if(isset($_GET['message'])){
    echo '<h6>'.$_GET['message'].'</h6>';
}
if(isset($_GET['deletemsg'])){
    echo '<h6>'.$_GET['deletemsg'].'</h6>';
}
if(isset($_GET['inserted'])){
    echo '<p>'.$_GET['inserted'].'</p>';
}
if(isset($_GET['updatemsg'])){
    echo '<p>'.$_GET['updatemsg'].'</p>';
}   
?>
</table>
<!-- Client INSERT MODAL -->
<form action="admin_insert.php?id=spr" method="POST" enctype="multipart/form-data">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content mt-0">
      <div class="modal-header mt-0">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Provider</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mt-0">
        <div class="form-group mt-0">
            <label for="uname">Full Name</label>
            <input type="text" id="uname" name="uname" class="form-control">
        </div>
        <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" min="1980-01-01" max="2012-12-31" class="form-control">
        </div>
        <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone"  maxlength="10" class="form-control">
        </div>
        <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="addr"  rows="1" class="form-control"></textarea>
        </div>
        <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" >
        </div>
        <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="passw" class="form-control" >
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" id="role" name="role" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-success" name="adminadd" value="Confirm">
      </div>
    </div>
  </div>
</div>
</form>

</body>
</html>

<!-- Confirm delete modal here -->
<form action="admin_delete.php?&role=spr" method="POST">
<div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content mt-0">
      <div class="modal-header mt-0">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirm Delete?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="uname" class="delete_uname">
        <p1>Are you sure, you want to delete this record?</p1>
      </div>

     <div class="modal-footer">
        <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-success" name="deleteuserbtn" value="Delete">
      </div>
    </div>
  </div>
</div>
</form>

<?php include('admin_footer.php');?>


<script>
    $(document).ready(function () {
        $(".delete-btn").click(function(){
            var uname = $(this).val();
            $(".delete_uname").val(uname);
            $("#deletemodal").modal('show');

        });
    });
</script>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: service provider.php");
elseif($_SESSION['role'] == 'client'):
    header("location: client.php");
endif; ?>