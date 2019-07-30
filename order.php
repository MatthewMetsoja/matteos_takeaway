<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Menu.php";
require_once "models/Basket.php";
require_once "includes/head.php";
$order = new Basket;
require_once "includes/navigation_order.php";
 
if(isset( $_COOKIE[getenv(SEC_BASKET_COOKIE)] ) &&  $order->basket_price_nav() !== "0.00" )
{ ?>

    <div id="order_jumbo" class="jumbotron jumbotron-fluid">
        <div id="jumbo_belly"> 
            <h1 id="order_title" class="it">Almost there </h1>

                <p id="order_intro" class="lead text-center"> 
                Please double check your order. If you would like to add or remove anything that is already in your basket please click the green <span id="fake_plus_1">+</span>
                sign to add one more, or click the red <span id="fake_minus_1">-</span> minus sign to take away one until you reach your desired amount. Forgot something? Click the link 
                above to return to the menu and add what you're missing. <br>
                
                </p>

        
        </div> 
    </div>


    <div class="container-fluid" id="order_contain" >
        
        <div class="row">
            <div id="" class="col-sm-12">
        
                <h3 id="check_order_title" class="menu_title"> <b>  Check order  </b> </h3>
                        
                <table id="order_table" class="table table-responsive table-inverse">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="15%">Name</th>
                            <th width= "5%">Price</th>
                            <th width="5%">Quantity</th>
                            <th width= "3%">Delete</th>
                            <th width= "5%">Total</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                            <?php  $order->show_basket(); ?> 
                    </tbody>
                </table>


                <div id="order_summary_div"class="float-left">
                        <span> <b> Total items: </b> </span> <?php $order->get_basket_total_count(); ?> <br>
                        <span> <b> Total Price:</b> </span> <?php $order->get_basket_total_price(); ?> <br>
                        <span> <b> 5% ONLINE DISCOUNT:</b></span>  <?php $order->get_basket_discount(); ?><br>
                    
                        <?php 
                        if($order->basket_price_nav() !== "0.00")
                        { ?>
                            <a  href="payment_page.php" id="onto_payment_btn" class="btn btn-sm btn-success"> 
                                <i class="fas fa-pizza-slice"></i> On to payment  £<?= $order->basket_price_nav(); ?> 
                            </a> <?php 
                        } ?>
                
                </div>
                      
            </div>

        </div>
    </div>

 <?php 
}
else  // basket is empty so lets delete cookie and redirect to menu  
{
    $order->delete_basket();
    header("location:index.php");
}

 
require_once "includes/footer.php"; 

?>