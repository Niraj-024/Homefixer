<?php 
include('../model/service_query.php');
include('header.php');
$title = 'Services we offer';
?>
<title>Services we offer</title>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<section class="sub-header">
    <h1 class="ab">Services We Offer</h1>
</section>
<div class="Services">
<?php
while($srow = mysqli_fetch_assoc($service)){
?>
    <div class="card">   
        <div class="img">
            <img src="/1HF/serviceimg/<?php echo $srow['image'];?>" alt="service image">
        </div>
        <div class="caption">
            <h3><?php echo $srow['s_name'];?></h3>
            <p><?php echo $srow['caption'];?></p>
        </div>
    </div>
    <?php
    }?>
</div>
</body>
<?php include('footer.php'); ?>
