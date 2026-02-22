<?php
include('../controller/db_conn.php');

// -------------------------- FOR USER INSERT
if(isset($_POST['adminadd'])){
    $name = $_POST['uname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $email = $_POST['email'];
    $passw = $_POST['passw'];
    $role = $_POST['role'];

    if($name=='' || $dob=='' || $phone=='' || $addr=='' || $email=='' || $passw=='' || $role==''){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $redirect = [
                'admin' => 'admin.php',
                'client' => 'admin_client.php',
                'spr' => 'admin_spr.php'
            ];
            header('location: '.$redirect[$id].'?message=***Fill all fields***');
            exit();
        }
    } else {
        $query = "INSERT INTO user (uname, email, password, phone, role, address, dob)
                  VALUES ('$name', '$email', '$passw', '$phone', '$role', '$addr', '$dob')";
        if($conn->query($query) === TRUE){
            $name = $addr = $dob = $email = $passw = $role = $phone ="";
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $redirect = [
                    'admin' => 'admin.php',
                    'client' => 'admin_client.php',
                    'spr' => 'admin_spr.php'
                ];
                header('location: '.$redirect[$id].'?inserted=***User created successfully***');
                exit();
            }
        } else {
            die("Couldn't insert user: ".$conn->error);
        }
    }
}

// -------------------------- FOR SERVICE INSERT
if(isset($_POST['serviceadd'])){
    $name = trim($_POST['sname']);
    $description = trim($_POST['description']);
    $season = !empty($_POST['season']) ? $_POST['season'] : 'all';

    if($name == '' || $description == ''){
        header('location:admin_service.php?err=***Fill all fields***');
        exit();
    }

    $allowedtypes = ['jpg','jpeg','png','gif'];
    $maxsize = 2 * 1024 * 1024; // 2MB
    $serviceDir = 'C:/xampp/htdocs/1HF/serviceimg/';

    if(empty($_FILES['file']['name'])){
        header('location:admin_service.php?err=***Select an image***');
        exit();
    }

    $iname = $_FILES['file']['name'];
    $tempname = $_FILES['file']['tmp_name'];
    $filesize = $_FILES['file']['size'];
    $filetype = strtolower(pathinfo($iname, PATHINFO_EXTENSION));

    if(!in_array($filetype, $allowedtypes)){
        header('location:admin_service.php?err=***Invalid file type***');
        exit();
    }

    if($filesize > $maxsize){
        header('location:admin_service.php?err=***File size exceeds 2MB***');
        exit();
    }

    if(file_exists($serviceDir . $iname)){
        header('location:admin_service.php?err=***File already exists***');
        exit();
    }

    if(!move_uploaded_file($tempname, $serviceDir . $iname)){
        die('Failed to move uploaded file.');
    }

    $query = "INSERT INTO service (s_name, description, image, season)
              VALUES ('$name', '$description', '$iname', '$season')";

    $result = mysqli_query($conn, $query);
    if(!$result){
        die('Failed Query: '.mysqli_error($conn).' | Query: '.$query);
    } else {
        header('location:admin_service.php?inserted=***Service Inserted***');
        exit();
    }
}
?>