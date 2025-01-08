<?php include ('../controller/session.php');
    include ('../controller/db_conn.php');
if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'client'):
    include('spr_header.php');
?>




<?php include('client_footer.php'); ?>

<?php 
elseif($_SESSION['role'] == 'client'):
    header("location: client_profile.php");
elseif($_SESSION['role'] == 'admin'):
    header("location: admin.php");
endif; ?>