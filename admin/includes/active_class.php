<?php

// active link settings 
//nav bar
$pageName = basename($_SERVER['PHP_SELF']);

$adminHome_page = 'index.php';
$orders_page = 'orders.php';
$menu_page = 'menu.php';
$staff_page = 'staff.php';


        $adminHomePageClass = '';
        $ordersPageClass = '';
        $productsPageClass = '';
        $staffPageClass = '';


    if($pageName === $adminHome_page){
       $adminHomePageClass = 'active';    
    }


    if($pageName === $orders_page){
      $ordersPageClass = 'active';    
    }

    if($pageName === $menu_page){
      $productsPageClass = 'active'; 
      Menu::show_success_flash();  Menu::show_error_flash();   
   }
   
    if($pageName === $staff_page){
      $staffPageClass = 'active';   
      Staff::show_success_flash();  Staff::show_error_flash();    
   }


//menu page sub menu
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 1){
      $starters_class = "active";
   }else
   {
      $starters_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 2){
      $pizza_class = "active";
   }else
   {
      $pizza_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 3){
      $pasta_class = "active";
   }else
   {
      $pasta_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 4){
      $rissoto_class = "active";
   }else
   {
      $rissoto_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 5){
      $fish_and_grill_class = "active";
   }else
   {
      $fish_and_grill_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 6){
      $sides_class = "active";
   }else
   {
      $sides_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 7){
      $deserts_class = "active";
   }else
   {
      $deserts_class = "";
   }
   if($pageName == $menu_page && (isset($_GET['category'])) && $_GET['category'] == 8){
      $drinks_class = "active";
   }else
   {
      $drinks_class = "";
   }


   function include_banner()
   {
      if($adminHomePageClass == "active"){
       
        }

   }



