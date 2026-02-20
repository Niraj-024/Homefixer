<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background-color: #f5f7fa;
        }

        .sidebar {
            width: 250px;
            background: #1e2b3a;
            color: white;
            padding: 20px;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .requests-section, .services-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .request-card {
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }

        .status-pending {
            background: #ffd700;
            color: #000;
        }

        .status-accepted {
            background: #2ecc71;
            color: white;
        }

        .status-completed {
            background: #3498db;
            color: white;
        }

        .menu-item a{
            text-decoration: none;
            color: white;
        }
        .menu-item {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;

        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .action-btn {
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .accept-btn {
            background: #2ecc71;
            color: white;
        }

        .decline-btn {
            background: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <h2>HOME FIXER</h2>
        <div class="menu-item"><i class="fas fa-home"></i> Dashboard</div>
        <div class="menu-item"><i class="fas fa-bell"></i> Requests</div>
        <div class="menu-item"><i class="fas fa-cog"></i> Services</div>
        <div class="menu-item"><i class="fas fa-user"></i> Profile</div>
        <div class="menu-item"><i class="fas fa-chart-bar"></i><a href="logout.php">Logout</a></div>
    </div>

    <div class="main-content">
        <h1>Welcome Back, <?php echo $_SESSION["uname"]?>!</h1>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>New Requests</h3>
                <p>15</p>
            </div>
            <div class="stat-card">
                <h3>Active Jobs</h3>
                <p>8</p>
            </div>
            <div class="stat-card">
                <h3>Completed Jobs</h3>
                <p>245</p>
            </div>
            <div class="stat-card">
                <h3>Rating</h3>
                <p>4.9 ★</p>
            </div>
        </div>

        <div class="requests-section">
            <h2>New Client Requests</h2>
            <div class="request-card">
                <h3>House Cleaning</h3>
                <p>Client: John Smith</p>
                <p>Location: New York</p>
                <p>Date: December 1, 2024</p>
                <p>Duration: 3 hours</p>
                <div style="margin-top: 10px;">
                    <button class="action-btn accept-btn">Accept</button>
                    <button class="action-btn decline-btn">Decline</button>
                </div>
            </div>
            <div class="request-card">
                <h3>Deep Cleaning</h3>
                <p>Client: Emma Wilson</p>
                <p>Location: Brooklyn</p>
                <p>Date: December 3, 2024</p>
                <p>Duration: 5 hours</p>
                <div style="margin-top: 10px;">
                    <button class="action-btn accept-btn">Accept</button>
                    <button class="action-btn decline-btn">Decline</button>
                </div>
            </div>
        </div>

        <div class="services-section">
            <h2>Your Services</h2>
            <div class="service-item">
                <div>
                    <h3>Regular House Cleaning</h3>
                    <p>$25/hour</p>
                </div>
                <span class="status-badge status-active">Active</span>
            </div>
            <div class="service-item">
                <div>
                    <h3>Deep Cleaning</h3>
                    <p>$35/hour</p>
                </div>
                <span class="status-badge status-active">Active</span>
            </div>
            <div class="service-item">
                <div>
                    <h3>Organization Services</h3>
                    <p>$30/hour</p>
                </div>
                <span class="status-badge status-active">Active</span>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
elseif($_SESSION['role'] == 'client'):
    header("location: client.php");
endif; ?>
