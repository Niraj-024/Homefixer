<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="stylesheet" href="../css/client.css">
     </head>
<body>
<div class="d-flex">
    <!-- sidebar-->
    <aside id="sidebar">
        <div class="logo">
            <a href="client_profile.php"><img src="../css/img/logos.png" alt="Homefixer" height="60px" width="240px"></a>
        </div><hr class="mt-0">
        <!-- sidebar nav -->
        <ul class="sidebar-nav p-0">
            <li class="sidebar-items">
                <a href="client_profile.php" class="sidebar-link">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            
            <li class="sidebar-items">
                <a href="client_services.php" class="sidebar-link">
                    <i class="fa-solid fa-list"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="sidebar-items">
                <a href="client_booknew.php" class="sidebar-link">
                    <i class="fas fa-tasks"></i>
                    <span>Book service</span>
                </a>
            </li>
            <li class="sidebar-items">
                <a href="client_review_history.php" class="sidebar-link">
                <i class="fa-solid fa-star"></i>
                <span>My Reviews</span>
                </a>
            </li>
            <li class="sidebar-items">
                <a href="help.php" class="sidebar-link">
                <i class="fa-solid fa-question-circle"></i>
                <span>Help and Support</span>
                </a>
            </li>
        </ul><hr>
    <!-- sidebar nav ends -->
        <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-link ">
                <i class="fas fa-right-to-bracket"></i>
                <span>Logout</span>
                </a>
        </div>
    </aside>
    <!-- sidebar end -->

     <!-- main -->
    <div class="main overflow-auto">
        <div class="head p-3 text-center">
            <h4><i >Swift service bookings</i></h4>
        </div>
        

</body>
</html>