<?php
include('../controller/db_conn.php');
include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_GET['book'])) {
        $serviceType = htmlspecialchars(trim($_POST['serviceType']));
        $bookingDate = htmlspecialchars(trim($_POST['bookingDate']));
        $description = htmlspecialchars(trim($_POST['description']));
        $address = htmlspecialchars(trim($_POST['address']));
        $phone = htmlspecialchars(trim($_POST['contact']));

        $sql = "CREATE TABLE IF NOT EXISTS bookings (
            booking_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            service_type VARCHAR(255) NOT NULL,
            booking_date DATETIME NOT NULL,
            description TEXT NOT NULL,
            service_location VARCHAR(255) NOT NULL,
            contact_details VARCHAR(15) NOT NULL,
            provider_id INT DEFAULT NULL,
            status ENUM('pending', 'accepted', 'in progress', 'completed', 'cancelled') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES user(u_id) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT fk_provider FOREIGN KEY (provider_id) REFERENCES user(u_id) ON DELETE SET NULL ON UPDATE CASCADE
        )";

        if ($conn->query($sql) === TRUE) {
            $id = $_SESSION['id'];
            $status = 'pending';
            $sql = "INSERT INTO bookings (user_id, service_type, booking_date, description, service_location, contact_details, status) 
                VALUES ('$id', '$serviceType', '$bookingDate', '$description', '$address', '$phone', '$status')";

            if ($conn->query($sql) === TRUE) {
                $booking_id = $conn->insert_id;

                // File uploads
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB
                $uploadDir = 'C:/xampp/htdocs/1HF/booking_images/';

                if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                    foreach ($_FILES['images']['name'] as $index => $name) {
                        $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $fileSize = $_FILES['images']['size'][$index];
                        $tmpName = $_FILES['images']['tmp_name'][$index];

                        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
                            $uniqueName = uniqid('', true) . '.' . $fileType;
                            $imagePath = $uploadDir . $uniqueName;

                            if (move_uploaded_file($tmpName, $imagePath)) {
                                // Insert image path into the images table
                                $imageSql = "INSERT INTO booking_images (booking_id, image_path) VALUES ('$booking_id', '$uniqueName')";
                                $conn->query($imageSql);
                            }
                        }
                    }
                }

                echo "Booking successful!";
                header("Location: client_book_current.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }
    }
}

// For cancelling pending booking from clients
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['bid'])) {
    $bid = $_SESSION['bid'];
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = '$bid';";

    if ($conn->query($sql)) {
        unset($_SESSION['bid']);
        header('location: client_book_current.php?cancel=true');
        exit();
    } else {
        echo "Could not cancel booking: " . $conn->error;
    }
}
?>
<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>
