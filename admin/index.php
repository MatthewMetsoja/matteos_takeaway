<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("../models/Transaction.php");
require_once ("includes/active_class.php");
require_once ("includes/navigation.php");
$orders = new Transaction; 
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center"> <u> Live Orders  </u>  <i class="fas fa-pencil-alt    "></i>    </h1>
                
             <div id="empty_div_for_ajax"></div>

<?php require_once ("includes/footer.php"); ?>






