<?php 
$title = 'Register Here';
include('../controller/db_conn.php');
include('header.php');

// validation------------------
$uname_Err = $passw_Err = $phone_Err = $file_Err = "";
$email_Err = $role_Err = $dob_Err = $addr_Err = "";
$count = 0;

$uname = $addr = $dob = $email = $passw = $role = $phone = "";
$registrationMessage = '';  // Variable to hold the success/failure message

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
    
    // Form validation
    if(empty($uname)){
        $uname_Err = "*Enter your full name"; $count++;
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $uname)){
        $uname_Err = "*Use letters only"; $count++;
    }

    if(empty($phone)){
        $phone_Err = "*Enter your phone number"; $count++;
    } elseif (!preg_match("[(\+977)?[9][6-9]\d{8}]", $phone)){
        $phone_Err = "*Enter a valid phone number"; $count++;
    }

    if(empty($dob)){
        $dob_Err = "*Enter your valid date of birth"; $count++;
    }

    if(empty($email)){
        $email_Err = "*Enter your email address"; $count++;
    }

    if(empty($addr)){
        $addr_Err = "*Enter your current address"; $count++;
    } elseif (!preg_match("#[\d{1,5}\s\w.\s(\b\w*\b\s){1,2}\w*\.]+#", $addr)){
        $addr_Err = "*Enter a valid address"; $count++;
    }

    if(empty($passw)){
        $passw_Err = "*Enter your password"; $count++;
    } elseif (strlen($passw) < 8 || !preg_match("#[0-9]+#", $passw) || !preg_match("#[a-z]+#", $passw) || !preg_match("#[A-Z]+#", $passw)){
        $passw_Err = "*Password must be at least 8 characters, include one number, lowercase, and uppercase letter"; $count++;
    }

    $role = $_POST['role'] ?? null;
    if (!$role) {
        $role_Err = "*Please select a role.";
        $count++;
    }

    /* ****** Check if Email or Phone Exists for Clients or Service Providers ****** */
    if ($count == 0) {
        // Check if the email is already used by the same role
        $checkEmailQuery = "SELECT u_id FROM user WHERE email = '$email' AND role = '$role'";
        $emailResult = $conn->query($checkEmailQuery);
        if ($emailResult->num_rows > 0) {
            $email_Err = "*Email already exists. Please use a different email.";
            $count++;
        }

        // Check if the phone number is already used by the same role
        $checkPhoneQuery = "SELECT u_id FROM user WHERE phone = '$phone' AND role = '$role'";
        $phoneResult = $conn->query($checkPhoneQuery);
        if ($phoneResult->num_rows > 0) {
            $phone_Err = "*Phone number already exists. Please use a different phone number.";
            $count++;
        }
    }

    // If no validation errors, proceed to file upload and database insertion
    if ($count == 0) {
        // Include the file validation script for file handling
        include('../controller/filevalidate.php');
        
        // Only insert user into the database if file upload was successful and no errors
        if (empty($file_Err)) {
            $sql = "INSERT INTO user (uname, email, password, phone, role, address, dob, image) 
                    VALUES ('$uname', '$email', '$passw', '$phone', '$role', '$addr', '$dob', '$fileName')";

            if ($conn->query($sql) === TRUE) {
                $successMessage = 'User created successfully!';
                // Reset form fields after successful registration
                $uname = $addr = $dob = $email = $passw = $role = $phone = "";
            } else {
                $registrationMessage = '<span class="error">Error: ' . $conn->error . '</span>';
            }
        } else {
            // If there is a file error, display the error and prevent insertion
            $registrationMessage = '<span class="error">' . $file_Err . '</span>';
        }
    } else {
        // Display validation errors as a single message
        $registrationMessage = '***Please fix the errors in the form***';
    }
    $conn->close();
}
?>

<body>
<span style="color: darkred; background-color:grey;"><?php if($registrationMessage) $registrationMessage; ?></span>
<span style="color: white; background-color:green;"><?php  $successMessage; ?></span>

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
                <input type="text" id="uname" name="uname" placeholder="Enter your name" value="<?php echo $uname; ?>" >
                <span><?php echo $uname_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" min="1980-01-01" max="2012-12-31" value="<?php echo $dob; ?>">
                <span><?php echo $dob_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Mobile No" maxlength="10" value="<?php echo $phone; ?>">
                <span><?php echo $phone_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="address">Address</label>
                <textarea id="address" name="addr" placeholder="Enter your current address" rows="1"><?php echo $addr; ?></textarea>
                <span><?php echo  $addr_Err;?></span>
            </div>

            <div class="sform-element">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" value="<?php echo $email; ?>">
                <span><?php echo $email_Err ;?></span>
            </div>

            <div class="sform-element">
                <label for="password">Password</label>
                <input type="password" id="password" name="passw" placeholder="Enter your password(at least 8 characters)" value="<?php echo $passw; ?>" >
                <span><?php echo  $passw_Err;?></span>
            </div>

            <div class="sform-element">
                <div class="sradio">
                    <label for="role">Select your role</label> <br>
                    <select name="role" id="role" >
                        <option value="0">--Select Role--</option>
                        <option value="spr" <?php if ($role == "spr") echo "selected"; ?>>Service provider</option>
                        <option value="client" <?php if ($role == "client") echo "selected"; ?>>Client</option>
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