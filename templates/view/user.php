<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Household Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="../css/stylee.css">
</head>
<body>
    <header class="header">
        <div class="hero">
            <nav id="mynavber">
                <img src="../css/img/logos.png" class="logo" style="height: 52px; width: 200px; margin-bottom: 0px;">
                <div class="nav-links">
                    <ul>
                        <li><a href="#">HOME</a></li>
                        <li><a href="#">BOOK SERVICES</a></li>
                        <li><a href="#">REVIEW</a></li>
                        <li><a href="#">CONTACT</a></li>
                    </ul>
                </div>
                <img src="../css/img/user.png" class="user-pic" onclick="toggleMenu()">
                <div class="sub-menu-wrap" id="submenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <img src="../css/img/user.png">
                            <h3><?php echo $_SESSION["uname"]?></h3>
                        </div>
                        <hr>
                        <a href="#"class="sub-menu-links">
                            <img src="../css/img/profile.png">
                            <p>Edit Profile</p>
                            <span>></span>
                        </a>
                        <a href="logout.php"class="sub-menu-links">
                            <img src="../css/img/logout.png">
                            <p>Logout</p>
                            <span>></span>
                        </a>
                    </div>
                 </div>
            </nav>
        </div>
        <!-- <nav class="nav">
            <h1>HomeServices</h1>
            <div class="user-profile">
                <div class="user-avatar"></div>
                <span>John Doe</span>
            </div>
        </nav> -->
    </header>

    <div class="search-bar">
        <input type="text" class="search-input" placeholder="What service do you need?">
        <select class="filter-select">
            <option>Location</option>
            <option>Kalimati</option>
            <option>Solteemode</option>
            <option>Tekku</option>
        </select>
        <!-- <select class="filter-select">
            <option>Price Range</option>
            <option>\$0-$50</option>
            <option>\$51-$100</option>
            <option>$100+</option>
        </select> -->
    </div>

    <div class="services-grid">
        <div class="service-card">
            <i class="fas fa-broom service-icon"></i>
            <h3>Cleaner</h3>
        </div>
        <div class="service-card">
            <i class="fas fa-hammer service-icon"></i>
            <h3>Electrician</h3>
        </div>
        <div class="service-card">
            <i class="fas fa-seedling service-icon"></i>
            <h3>Pumbler</h3>
        </div>
        <div class="service-card">
            <i class="fas fa-paint-roller service-icon"></i>
            <h3>Painting</h3>
        </div>
    </div>

    <div class="providers-section">
        <h2>Available Service Providers</h2>
        <div class="provider-card">
            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Provider" class="provider-img">
            <div class="provider-info">
                <div class="provider-name">Sarah Johnson</div>
                <div class="provider-rating">★★★★★ (4.9)</div>
                <div class="provider-price">$25/hour</div>
                <p>Professional house cleaner with 5 years of experience. Specialized in deep cleaning and organization.</p>
            </div>
            <button class="book-btn">Book Now</button>
        </div>

        <div class="provider-card">
            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Provider" class="provider-img">
            <div class="provider-info">
                <div class="provider-name">Mike Anderson</div>
                <div class="provider-rating">★★★★☆ (4.2)</div>
                <div class="provider-price">$35/hour</div>
                <p>Experienced handyman specializing in repairs, installations, and maintenance.</p>
            </div>
            <button class="book-btn">Book Now</button>
        </div>
    </div>
    <script>
        let submenu = document.getElementById("submenu");
        function toggleMenu(){
            submenu.classList.toggle("open-menu");
        }
    </script>
</body>

</html>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: service provider.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>

