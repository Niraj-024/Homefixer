<?php 
$title = 'Login';
include('header.php');
$login = false;
$errmsg = false;
// ---------validation----
if($_SERVER["REQUEST_METHOD"] == "POST"){
  include('../controller/db_conn.php');
  $uname = $_POST["uname"];
  $pass = $_POST["pass"];
  $sql = "SELECT * FROM user WHERE uname = '$uname'; ";   
  $result = $conn->query($sql);

  if($result->num_rows == 1){ //find for user
    while($row = mysqli_fetch_assoc($result)){
      if($pass == $row['password']){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['uname'] = $uname;
  
        $role = $row['role'];//fetch role
        $_SESSION['role'] = $role;
        //role based redirect
        if($role =='spr'){header("location:service provider.php");}
        if($role =='client'){header("location:client_profile.php");}
        if($role =='admin'){header("location:admin.php");}
      }else{
        $errmsg = "Invalid , try again !";
      }
    }
  }else{
    $errmsg = "Invalid Credentials, try again !";
  }
}
?>
<!doctype html>
<html>
<body>
<span class="span"><?php echo $errmsg ; ?></span>
<div class="popup" id="myForm">
    <a> <img src="../css/img/logos.png" alt="HF" class="img" style="height: 52px; width: 200px; margin-bottom: 0px;"></a>

    <div class="close-btn">
      <a href="index.php"><button type="button" class="btn-cancel">&times;</button></a>
    </div>
    <div class="form">
      <h2>Login to continue</h2>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

          <div class="form-element">
            <label for="uname">Username</label>
            <input type="text" id="uname" name="uname" placeholder="Enter your username"  required>
          </div>

          <div class="form-element">
            <label for="password">Password</label>
            <input type="password" id="pass" name="pass" placeholder="Enter your password" required>
          </div>

          <div class="form-element">
            <button type="submit" name="login" value="login">Sign in</button>
          </div>

          <div class="form-element">
            <a class="a2" href="signup.php">Don't have an account ?</a>
          </div>
      </form>
    </div>
</div>
</body>
</html>
