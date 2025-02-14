<?php 
$title = 'Register Here';
include('../controller/db_conn.php');
include('header.php');

// validation------------------
$uname_Err= $passw_Err = $phone_Err = $file_Err = "";
$email_Err = $role_Err = $dob_Err  = $addr_Err ="";
$count = 0;

$uname = $addr = $dob = $email = $passw = $role = $phone ="";

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['signup'])){
    $uname = test_input($_POST["uname"]);
    $addr   = test_input($_POST["addr"]);
    $dob    = test_input($_POST["dob"]);
    $email  = test_input($_POST["email"]);
    $passw  = test_input($_POST["passw"]);
    $phone  = test_input($_POST["phone"]);
    include('../controller/filevalidate.php');


    if(empty($uname)){
        $uname_Err = "*Enter your first name";
        $count+=1;
    }else{
        if(!preg_match("/^[a-zA-Z ]+$/", $uname)){
            $uname_Err = "*use letters only";
            $count+=1;
        }
    }
    if(empty($phone)){
        $phone_Err = "*Enter your current phone number";$count+=1;
    }else{
        if(!preg_match("[(\+977)?[9][6-9]\d{8}]", $phone)){
            $phone_Err = "*Enter valid phone number";$count+=1;
        }
    }
    if(empty($dob)){
        $dob_Err = "*Enter your valid date of birth";$count+=1;
    }
    if(empty($email)){
        $email_Err = "*Enter your email address";$count+=1;
    }
    if(empty($addr)){
        $addr_Err = "*Enter your current address";$count+=1;
    }else{
        if(!preg_match("#[\d{1,5}\s\w.\s(\b\w*\b\s){1,2}\w*\.]+#", $addr)){
            $addr_Err = "*Enter a valid address";$count+=1;
        }
    }
    if(empty($passw)){
        $passw_Err = "*Enter your password";$count+=1;
    }else{
        if(strlen($passw)<8){
        $passw_Err = "*Password must be at least 8 characters";$count+=1;
        }elseif(!preg_match("#[0-9]+#", $passw)){
        $passw_Err = "*include at least one number, small and an uppercase letter";$count+=1;
        }elseif(!preg_match("#[a-z]+#", $passw)){
        $passw_Err = "**include at least one number, small and an uppercase letter";$count+=1;
        }elseif(!preg_match("#[A-Z]+#", $passw)){
        $passw_Err = "*include at least one number, small and an uppercase letter";$count+=1;
        }
      }
    
    $role = $_POST['role'] ?? null;
    if (!$role) {
        $role_Err = "Please select a role.";
    }

    
/* ****** SQL -->*/
if($count==0){
// $hash = password_hash($passw, PASSWORD_DEFAULT);

$sql = " INSERT INTO user (uname ,email ,password, phone, role, address, dob, image)
VALUES ('$uname', '$email', '$passw','$phone','$role', '$addr', '$dob', '$fileName')" ;
if($conn->query($sql) === TRUE){
    echo "User created successfully &nbsp;";
    $uname = $addr = $dob = $email = $passw = $role = $phone ="";
}else{
    echo "Couldn't insert data  $sql ". $conn->error;
}

}
$conn->close();
}

?>

 
<!-- popup*************** -->
<body>
<!-- <span><?php echo $msg ; ?></span> -->

<div class="spopup" id="smyForm">
    <a>
        <img src="../css/img/logos.png" alt="HF" class="img" style="height: 52px; width: 210px; margin-bottom: 0px;">
    </a>

    <div class="sclose-btn">
        <a href="index.php"><button type="button" class="sbtn-cancel">&times;</button></a>
    </div>


    <div class="sform">
        <h2>Create a new account</h2>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div class="sform-element">
                <label for="user_name">Full Name</label>
                <input type="text" id="uname" name="uname" placeholder="Enter your name" >
                <span><?php echo $uname_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" min="1980-01-01" max="2012-12-31">
                <span><?php echo $dob_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Mobile No" maxlength="10">
                <span><?php echo $phone_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="address">Address</label>
                <textarea id="address" name="addr" placeholder="Enter your current address" rows="1"></textarea>
                <span><?php echo  $addr_Err;?></span>
            </div>

            <div class="sform-element">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" >
                <span><?php echo $email_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="password">Password</label>
                <input type="password" id="password" name="passw" placeholder="Enter your password(at least 8 characters)" >
                <span><?php echo  $passw_Err;?></span>
            </div>

            <div class="sform-element">
                <div class="sradio">
                    <label for="role">Select your role</label> <br>
                    
                        <select name="role" id="role" >
                        <option value="0">--Select Role--</option>
                           <option value="spr">Service provider</option>
                            <option value="client">Client</option>
                        </select>
                </div>
                    <span><?php echo  $role_Err;?></span>
            </div>

            <div class="sform-element">
                <label for="file">Insert a legal document</label>
                <label class="f2" for="file" style="font-size: 10px;">(license/citizenship)</label>
                <input type="file" name="file">
                <span><?php echo  $file_Err;?></span>
            </div>

            <div class="sform-element">
                <button type="submit" name ="signup">Sign Up</button>
            </div>
        </form>
    </div>
</div>
</body>
