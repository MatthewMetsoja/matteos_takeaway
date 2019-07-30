<?php

require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Basket.php";
require_once "includes/head.php";
$basket = new Basket;
require_once "includes/navigation_payment.php";

if(isset($_GET['tid']))
{
    $order_reference_number = filter_var($_GET['tid'],FILTER_SANITIZE_STRING);
} 

if(isset($_GET['product']))
{
    $order_name = filter_var($_GET['product'],FILTER_SANITIZE_STRING);
} 
  

// delete basket from basket table;
$basket->delete_basket();

?>

<div id="main_menu_div">
              
    <div id="success_jumbo" class="jumbotron jumbotron-fluid">
        <div id="jumbo_belly"> 
            <h1 id="payment_title" class="it">Thank you!  </h1>
  
                <p class="lead text-center"> 
                    Your payment was processed successfully!
                    Your order reference number and details are below. We aim to deliver within the hour.
                    Please call us on the number above quoting your order reference number if you have any problems
                    with your order.           
                </p>
                <br>
        </div> 
    </div>

<div class="container-fluid" id="order_contain">

    <div class="row">
        <div id="" class="col-sm-12">
    
            <h3 id="check_order_title" class="menu_title"> <b>   We hope you enjoy your meal.  </b> </h3>
                
            <hr>
            
            <div class="container">
                <div class="row"> 
                    <div class="col-1"></div>
                    
                    <div class="col-10">
                        <h6>Order Reference Number: <small>  <?= $order_reference_number ?> </small></h6>
                        <h6>Order as shown on card: <small>  <?= $order_name ?>  </small></h6>
                    </div>

                    <div class="col-1"></div>

                </div>                
            
            </div>

        </div>
    </div>

</div>

<hr>

<?php require_once "includes/footer.php"; ?>







