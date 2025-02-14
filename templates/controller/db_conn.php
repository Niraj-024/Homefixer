<?php
// DB connectivity
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homefixer_db";
$msg = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $msg = "Database not connected &nbsp;";
    die("Failed connecting to server..." . $conn->connect_error);
} else {
    $msg = "Database connected &nbsp;";

    // SQL queries to create the tables if they don't exist
    $createUserTable = "
    CREATE TABLE IF NOT EXISTS user (
        u_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        uname VARCHAR(30) NOT NULL,
        password VARCHAR(40) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        address VARCHAR(50) NOT NULL,
        dob DATE NOT NULL,
        role VARCHAR(8) NOT NULL,
        image VARCHAR(100) NOT NULL,
        created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        isactive TINYINT(1) NOT NULL DEFAULT 1,
        issuper TINYINT(1) NOT NULL DEFAULT 0
    )";

    $createBookingsTable = "
    CREATE TABLE IF NOT EXISTS bookings (
        booking_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        service_type VARCHAR(255) NOT NULL,
        booking_date DATETIME NOT NULL,
        description TEXT NOT NULL,
        service_location VARCHAR(255) NOT NULL,
        contact_details VARCHAR(15) NOT NULL,
        provider_id INT(11) DEFAULT NULL,
        status ENUM('pending', 'cancelled', 'accepted', 'completed', 'in progress') DEFAULT 'pending' NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
        INDEX (user_id),
        INDEX (provider_id)
    )";

    $createBookingImagesTable = "
    CREATE TABLE IF NOT EXISTS booking_images (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        booking_id INT(11) NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        INDEX (booking_id)
    )";

    $createReviewsTable = "
    CREATE TABLE IF NOT EXISTS reviews (
        review_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        booking_id INT(11) NOT NULL,
        rating TINYINT(4) NOT NULL,
        comments TEXT DEFAULT NULL,
        review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX (booking_id)
    )";

    $createServiceTable = "
    CREATE TABLE IF NOT EXISTS service (
        s_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        s_name VARCHAR(50) NOT NULL,
        caption VARCHAR(255) NOT NULL,
        image VARCHAR(100) NOT NULL,
        created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    )";

    $createSupportTable = "
    CREATE TABLE IF NOT EXISTS support (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) DEFAULT NULL,
        role VARCHAR(15) DEFAULT NULL,
        subject VARCHAR(255) DEFAULT NULL,
        message TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    )";

    // Execute the queries
    $queries = [
        $createUserTable,
        $createBookingsTable,
        $createBookingImagesTable,
        $createReviewsTable,
        $createServiceTable,
        $createSupportTable
    ];

    foreach ($queries as $query) {
        if ($conn->query($query) === TRUE) {
            $msg .= "Table created successfully &nbsp;";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    }
}
?>