<?php include ('../controller/session.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'spr'):
    include('client_header.php');
?> 



<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'spr'):
    header("location: spr_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>