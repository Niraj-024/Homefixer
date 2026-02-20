<?php
if(isset($_POST['adminadd'])){
    include('../controller/db_conn.php');
    $name = $_POST['uname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $email = $_POST['email'];
    $passw = $_POST['passw'];
    $role = $_POST['role']; //make sure to empty all these after submit

    if($name==''|| $dob==''|| $phone==''|| $addr==''|| $email=='' || $passw=='' || $role==''|| 
    empty($name) ||empty($dob) ||empty($phone) ||empty($addr) ||empty($email) ||empty($passw) ||empty($role)){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($id == "admin"){
                header('location: admin.php?message=***Fill all fields***');
            }
            if($id == "client"){
                header('location: admin_client.php?message=***Fill all fields***');
            }
            if($id == "spr"){
                header('location: admin_spr.php?message=***Fill all fields***');
            }
        }
    }
    else{
    $query = " INSERT INTO user (uname ,email ,password, phone, role, address, dob)
    VALUES ('$name', '$email', '$passw','$phone','$role', '$addr', '$dob');" ;
    if($conn->query($query) === TRUE){
        $name = $addr = $dob = $email = $passw = $role = $phone ="";
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($id == "admin"){
                header('location: admin.php?inserted=***User created successfully***');
            }
            if($id == "client"){
                header('location: admin_client.php?inserted=***User created successfully***');
            }
            if($id == "spr"){
                header('location: admin_spr.php?inserted=***User created successfully***');
            }
        }
    }else{
        die("Couldn't insert data  $query ". $conn->error);
    }
    }
}

//--------------------------for service

if(isset($_POST['serviceadd'])){
    include('../controller/db_conn.php');

    $name =  $_POST['sname'];
    $caption = $_POST['caption'];

    $allowedtypes = array('jpg', 'jpeg', 'png', 'gif'); // Allowed file types
    $maxsize = 2 * 1024 * 1024; // Maximum file size in bytes (2MB)
    $serviceDir = 'C:/xampp/htdocs/1HF/serviceimg/'; //for service

    
    if(!empty($_FILES['file']['name'])){
        $iname = $_FILES['file']['name'];
        $tempname =  $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $filetype = strtolower(pathinfo($iname, PATHINFO_EXTENSION));

        if(in_array($filetype , $allowedtypes)){
            if($filesize <= $maxsize){
                if(!file_exists($serviceDir . $iname)){
                    move_uploaded_file($tempname , $serviceDir.$iname);

                    $query = "INSERT into service (s_name, caption, image) values ('$name', '$caption', '$iname' )";
                    $result = mysqli_query($conn, $query);
                    if(!$result){
                        die('Failed Query'.$conn->error);
                    }else{
                        header('location:admin_service.php?inserted=***Service Inserted***');
                        exit();
                    }

                }else{
                    header('location:admin_service.php?err=***File already exists***');exit();
                }
            }else{
                header('location:admin_service.php?err=***File size exceeds 2mb ***');exit();
            }
        }else{
            header('location:admin_service.php?err=***Invalid file type***');exit();
        }

        
    } 
}

?>