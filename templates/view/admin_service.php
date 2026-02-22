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
    <title>Manage Services</title>
</head>
<body>
<h2>Manage Services</h2>
<div class="mb-10">
    <button class="btn btn-primary float-end mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >Add New Service</button>
</div>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Caption</th>
            <th>Season</th>
            <th>Image</th>
            <th>Created on</th>
            <th class="d-flex justify-content-around" >Action</th>
        </tr>
    </thead>
    <tbody>
   <?php
        $query = 'SELECT * FROM service';
        $result = mysqli_query($conn, $query);

        if(!$result){
            die("Query failed: ".$conn->error);
        } else {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
   ?>
        <tr>
            <td><?php echo $row['s_id']; ?></td>
            <td><?php echo htmlspecialchars($row['s_name']); ?></td>
            <td class="col-3"><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo ucfirst($row['season']); ?></td>
            <td><img src="/1HF/serviceimg/<?php echo htmlspecialchars($row['image']); ?>" alt="Service Image" style="width: 100px; height: auto;"></td>
            <td><?php echo $row['created_at']; ?></td>
            <td class="d-flex justify-content-between">
              <a href="admin_update.php?id=<?php echo $row['s_id'];?>" class="btn btn-primary">Update</a>
              <button class="btn btn-danger delete-btn" type="button" value="<?php echo $row['s_id']; ?>">Delete</button>
            </td>
        </tr>
   <?php
                }
            } else {
              echo '<tr><td colspan="7">***NO records found***</td></tr>';
          }
        }
   ?>
   </tbody>
</table>

<!-- Service INSERT MODAL -->
<form action="admin_insert.php" method="POST" enctype="multipart/form-data">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content mt-0">
      <div class="modal-header mt-0">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Service</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mt-0">
        <div class="form-group mt-0">
            <label for="sname">Service Name</label>
            <input type="text" id="sname" name="sname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="season">Season</label>
            <select id="season" name="season" class="form-control" required>
                <option value="all">All</option>
                <option value="summer">Summer</option>
                <option value="monsoon">Monsoon</option>
                <option value="winter">Winter</option>
            </select>
        </div>
        <div class="form-group">
            <label for="file">Image</label>
            <input type="file" id="file" name="file" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-success" name="serviceadd" value="Confirm">
      </div>
    </div>
  </div>
</div>
</form>

<!-- Confirm delete modal -->
<form action="admin_delete.php" method="POST">
<div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content mt-0">
      <div class="modal-header mt-0">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirm Delete?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="s_id" class="delete_sname">
        <p>Are you sure you want to delete this record?</p>
      </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-success" name="deleteservicebtn" value="Delete">
      </div>
    </div>
  </div>
</div>
</form>

<?php include('admin_footer.php');?>

<script>
$(document).ready(function () {
    $(".delete-btn").click(function(){
        var s_id = $(this).val();
        $(".delete_sname").val(s_id);
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