<?php 
$title = 'Login';
include('header.php');
$login = false;
$errmsg = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../controller/db_conn.php');
    session_start();
    
    $uname = $_POST["uname"];
    $pass = $_POST["pass"];

    //fetch all info
    $sql = "SELECT * FROM user WHERE uname = '$uname'";
    $result = $conn->query($sql);
    $num_rows = $result->num_rows;

    if ($num_rows == 0) {  

      //user not found
      $errmsg = "Invalid Credentials, try again!";
    } elseif ($num_rows == 1) {  
        // found one row, means one role
        $row = mysqli_fetch_assoc($result);
        if ($pass == $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['uname'] = $uname;
            $_SESSION['id'] = $row['u_id'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'spr') { header("location:spr_profile.php"); exit; }
            if ($row['role'] == 'client') { header("location:client_profile.php"); exit; }
            if ($row['role'] == 'admin') { header("location:admin.php"); exit; }
        } else {
            $errmsg = "Invalid Password, try again!";
        }
    } else {  
        // for multi role
        $_SESSION['uname'] = $uname;
        $_SESSION['password'] = $pass;

        echo "<h3>Select Your Role:</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='role' value='{$row['role']}'>";
            echo "<button type='submit'>{$row['role']}</button>";
            echo "</form>";
        }
        exit;
    }
}

// Handle role selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role'])) {
    $role = $_POST['role'];
    $uname = $_SESSION['uname'];
    $pass = $_SESSION['password'];

    // get user info for selected role
    $sql = "SELECT * FROM user WHERE uname = '$uname' AND role = '$role'";
    $result = $conn->query($sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && $pass == $user['password']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $user['u_id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($role == 'spr') { header("location:spr_profile.php"); exit; }
        if ($role == 'client') { header("location:client_profile.php"); exit; }
        if ($role == 'admin') { header("location:admin.php"); exit; }
    } else {
        $errmsg = "Invalid Credentials!";
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
