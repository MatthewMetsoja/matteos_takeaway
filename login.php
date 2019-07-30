<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "includes/head.php";
require_once "models/Staff.php";
require_once "includes/navigation_about_us.php";

$staff = new Staff;


require_once ("includes/footer.php"); 

?>