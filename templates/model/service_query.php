<?php
include('../controller/db_conn.php');
$sql = "SELECT *  FROM service";
$service = $conn->query($sql); 
?>