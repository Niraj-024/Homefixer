<?php
include ('../controller/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Welcome, <?php echo $_SESSION['uname'] ;?></h2><hr>
        <div class="menu-item">
            <a href="admin.php" class="sidebar-link">
                <i class="fas fa-user-shield"></i>
                <span>Admins</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="admin_client.php" class="sidebar-link">
                <i class="fas fa-user"></i>
                <span>Clients</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="admin_spr.php" class="sidebar-link">
                <i class="fas fa-user-cog"></i>
                <span>Service Providers</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="admin_service.php" class="sidebar-link">
                <i class="fas fa-tools"></i>
                <span>Services</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="admin_books.php" class="sidebar-link">
                <i class="fas fa-calendar"></i>
                <span>All Bookings</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="admin_reviews.php" class="sidebar-link">
                <i class="fas fa-star"></i>
                <span>All Reviews</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="logout.php" class="sidebar-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</body>
</html>