<?php

$allowedTypes = array('jpg', 'jpeg', 'png', 'gif'); // Allowed file types
$maxSize = 2 * 1024 * 1024; // Maximum file size in bytes (2MB)
$uploadDir = 'C:/xampp/htdocs/1HF/db_images/'; // Directory to upload files

    // Check if a file was selected
    if (!empty($_FILES['file']['name'])) {
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Check if file size is within the limit
            if ($fileSize <= $maxSize) {
                // Check if file already exists
                if (!file_exists($uploadDir . $fileName)) {
                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
                        echo "File uploaded successfully! &nbsp;";
                    } else {
                        $file_Err = "File upload failed. &nbsp; ";
                        $count++;
                    }
                } else {
                    $file_Err = "File already exists. &nbsp;";
                    $count++;
                }
            } else {
                $file_Err = "File size exceeds the limit. &nbsp;";
                $count++;
            }
        } else {
            $file_Err = "Invalid file type. &nbsp;";
            $count++;
        }
    } else {
        $file_Err = "No file selected. &nbsp;";
        $count++;
    } 

?>