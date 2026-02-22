<?php
include('../controller/db_conn.php');
include('header.php');

$title = 'Services we offer';

/* -------- detect current season -------- */

$month = date("m");

if($month >= 3 && $month <= 5){
    $current_season = "summer";
}
elseif($month >= 6 && $month <= 8){
    $current_season = "rainy";
}
elseif($month >= 9 && $month <= 11){
    $current_season = "festive";
}
else{
    $current_season = "winter";
}

/* -------- seasonal services query -------- */

$season_query = "SELECT * FROM service 
                 WHERE season = '$current_season' 
                 OR season = 'all'
                 ORDER BY created_at DESC";

$season_result = mysqli_query($conn, $season_query);

/* -------- all services query -------- */

$all_query = "SELECT * FROM service ORDER BY created_at DESC";
$all_result = mysqli_query($conn, $all_query);
?>

<title>Services we offer</title>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<section class="sub-header">
    <h1 class="ab">Services We Offer</h1>
</section>


<!-- trending section -->
<section class="trending">
    <h2 class="section-title">Trending This Season</h2>

    <div class="Services">
        <?php while($row = mysqli_fetch_assoc($season_result)){ ?>
            <div class="card">
                <div class="img">
                    <img src="/1HF/serviceimg/<?php echo $row['image']; ?>" alt="service image">
                </div>
                <div class="caption">
                    <h3><?php echo $row['s_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>


<!-- all services -->
<section class="all-services">
    <h2 class="section-title">All Services</h2>

    <div class="Services">
        <?php while($row = mysqli_fetch_assoc($all_result)){ ?>
            <div class="card">
                <div class="img">
                    <img src="/1HF/serviceimg/<?php echo $row['image']; ?>" alt="service image">
                </div>
                <div class="caption">
                    <h3><?php echo $row['s_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

</body>

<?php include('footer.php'); ?>