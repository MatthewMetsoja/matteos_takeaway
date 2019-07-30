<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("../models/Transaction.php");

$orders = new Transaction; 


$orders->get_orders_for_the_day();


?>










