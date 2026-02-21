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
    die("Failed connecting to server..." . $conn->connect_error);
} 

$createUserTable = "
CREATE TABLE IF NOT EXISTS user (
    u_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    dob DATE DEFAULT NULL,
    role ENUM('client', 'spr', 'admin') NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    is_approved TINYINT(1) NOT NULL DEFAULT 0,
    is_super TINYINT(1) NOT NULL DEFAULT 0
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
    status ENUM('pending', 'cancelled', 'accepted', 'completed', 'in_progress') DEFAULT 'pending' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (provider_id)
)";

$createBookingImagesTable = "
CREATE TABLE IF NOT EXISTS booking_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    booking_id INT(11) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (booking_id)
)";

$createReviewsTable = "
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    booking_id INT(11) NOT NULL,
    rating TINYINT(4) NOT NULL,
    comments TEXT DEFAULT NULL,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) NOT NULL DEFAULT 1,
    INDEX (booking_id)
)";

$createServiceTable = "
CREATE TABLE IF NOT EXISTS service (
    s_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    s_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$createSupportTable = "
CREATE TABLE IF NOT EXISTS support (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) DEFAULT NULL,
    role ENUM('client', 'provider', 'admin') DEFAULT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    $conn->query($query);
}

?>