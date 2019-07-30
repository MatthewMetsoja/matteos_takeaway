<?php
require_once "config/pdo_db.php";
require_once "models/Basket.php";

$Add_to_basket = new Basket;

echo ob_get_clean(); 



