<?php
// DB connectivity
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homefixer_db";
$msg ="";

$conn = new mysqli($servername , $username , $password , $dbname);

if ($conn->connect_error ){
    $msg = "Database not connected &nbsp;";
    die("Failed connecting to server..." . $conn->connect_error);
}else{
    $msg = "Database connected &nbsp;";
    $conn->select_db($dbname);
}
?>