<?php
session_start();

// Validate session
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['session_id']) || $_SESSION['session_id'] !== session_id()) {
    header("location: login.php");
    exit;
}
?>