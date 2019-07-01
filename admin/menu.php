<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("../models/Menu.php");
require_once ("includes/active_class.php");
require_once ("includes/navigation.php");

Menu::delete_item_verification();  
?>

<div class="container-fluid">
<div class="alert-danger text-danger"> <?= Menu::$delete_error_message ?> </div>
 
<div class="row">
        <div class="col sm-12">
            <h1 class="text-center mb-3"> <a href="menu.php">  <i class="fa fa-book" aria-hidden="true"></i> </i> Menu  </a>  </h1>

            <?php   if(!isset($_GET['add_item']) && (!isset($_GET['edit_item']) )  )
                    { ?>   
                        <div class="text-center mb-3">  <a href="menu.php?add_item=yes" class="btn btn-success">Click here to Add new item</a> </div> 
                        <div class="alert-danger text-danger"> <?= Menu::$delete_error_message ?> </div>
                           
                           <div class="text-center mb-4"> 
                                <a class="sub_menu <?= $starters_class ?>" href="menu.php?category=1">Starters </a> 
                                <a class="sub_menu <?= $pizza_class ?>" href="menu.php?category=2">Pizza</a> 
                                <a class="sub_menu <?= $pasta_class ?>" href="menu.php?category=3">Pasta</a> 
                                <a class="sub_menu <?= $rissoto_class ?>" href="menu.php?category=4">Rissoto</a> 
                                <a class="sub_menu <?= $fish_and_grill_class ?>" href="menu.php?category=5">Fish & grill </a> 
                                <a class="sub_menu <?= $sides_class ?>" href="menu.php?category=6">Sides </a> 
                                <a class="sub_menu <?= $deserts_class ?>" href="menu.php?category=7">Deserts</a> 
                                <a class="sub_menu <?= $drinks_class ?>" href="menu.php?category=8">Drinks</a> 
                           </div>
                    
                      <?php
                    } ?>
        
        </div> 
    </div>     
    <div class="row">   
        <div class="d-none d-sm-block col-1"> </div>  
       
        <div class="col-sm-10">  
           <?php $menu = new Menu; ?>
          
        </div> 

        <div class="d-none d-sm-block col-1"> </div>  

    </div>

    <div class="alert-danger text-danger text-center"> <?= Menu::$delete_error_message ?> </div>
  
</div>


<?php require_once "includes/footer.php";




