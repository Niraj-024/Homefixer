<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('../model/service_query.php');
    include('client_header.php');
?> 

<div class="service-main m-2 bg-white shadow-sm">
    <div class="shead text-center ">
        <h4 class="">Available Services</h4>
    </div>

    <div class="container my-4">
    <div class="row g-3">
        <?php while ($srow = mysqli_fetch_assoc($service)) { ?>
            <div class="col-xl-3 col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="card shadow-sm" style="width: 100%;">
                    <img class="card-img-top img-fluid mx-auto d-block" src="/1HF/serviceimg/<?php echo ($srow['image']); ?>" alt="Service image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo ($srow['s_name']); ?></h5>
                        <p class="card-text"><?php echo ($srow['caption']); ?></p>
                        <a href="#" class="btn btn-primary mt-auto">Book Now</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


</div>


<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: service provider.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>