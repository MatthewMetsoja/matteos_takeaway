<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("includes/active_class.php");
require_once ("../models/Menu.php");
require_once ("includes/navigation.php");

$menu = new Menu;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col sm-12">
            <h1 class="text-center mb-2"> <i class="fas fa-money-bill-wave"></i> Orders  </h1>
           


        </div>
    </div>
</div>



<?php require_once ("includes/footer.php"); ?>