<?php 
include ('../controller/session.php');
include('../controller/db_conn.php');
$user_id = $_SESSION['id'];
if ($user_id) :
?> 

<?php
    // Query to fetch user information
    $userQuery = "SELECT uname, email, role FROM user WHERE u_id = $user_id";
    $result = $conn->query($userQuery);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = htmlspecialchars($user['uname']);
        $email = htmlspecialchars($user['email']);
        $role = htmlspecialchars($user['role']);
        if($role == 'client'){ include('client_header.php');}
        elseif($role == 'spr'){ include('spr_header.php');}
    } else {
        $name = $email = $role = "Unknown";
    }

$createTable = "
    CREATE TABLE IF NOT EXISTS support (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        subject VARCHAR(255),
        message TEXT,
        role varchar(15),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
";
$conn->query($createTable);

// form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $insertQuery = "INSERT INTO support (user_id, subject, message, role)
        VALUES ($user_id, '$subject', '$message', '$role'); ";

    if ($conn->query($insertQuery) === TRUE) {
        $successMessage = "Your query has been submitted successfully.";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}
?>
<title>Help & Support</title>

<div class="container m-3 p-3 w-auto h-auto border ">
    <h1 class="mb-4 text-center">Help & Support</h1>
    <!-- Display Success or Error Messages -->
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>
    <!-- Support Contact Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Contact Our Support Team</h5>
            <p>Email: <a href="mailto:support@homefixer.com.np">support@homefixer.com.np</a></p>
            <p>Phone: +977 9803426888</p>
            <p>Working Hours: Sunday to Friday, 9 AM - 6 PM</p>
        </div>
    </div>
    <!-- Contact Form -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Submit Your Query</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" value="<?= $name ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?= $email ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" class="form-control" id="role" value="<?= $role ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include('client_footer.php'); ?>

<?php 
else :
    header("Location: login.php");
    exit;
endif; ?>