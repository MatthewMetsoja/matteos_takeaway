<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Menu.php";
require_once "models/Basket.php";
require_once "includes/head.php";
$order = new Basket;
require_once "includes/navigation_payment.php";

// redirect to menu if basket if empty and user has managed to get this far
if($order->basket_price_nav() == "0.00")
{
    $order->delete_basket();    
}

?>
 
<div id="main_menu_div">
              
    <div id="payment_jumbo" class="jumbotron jumbotron-fluid">
        <div id="jumbo_belly"> 
            <h1 id="payment_title" class="it">Payment  <small>£</small><?= $order->basket_price_nav(); ?>  </h1>
  
                <p class="lead text-center"> 
                    Please enter your payment details and delivery address below. 
                    Please do not hesistate to call us if you encounter any problems ordering.
                </p>     <br>  
        </div> 
    </div>

<div class="container-fluid" id="order_contain">

    <div class="row">
            <div id="" class="col-sm-12">
            
                <h3 id="check_order_title" class="menu_title"> <b>  Details  </b> </h3>
            
                <div class="container">

                    <form action="./charge.php" method="post" id="payment-form">
                    
                        <div class="form-row">
                            <div class="text-danger" id="first_name_alert"> </div>
                            <input type="text" class="form-control mb-3 StripeElement--empty" pattern="[a-zA-Z ]*" id="first_name" name="first_name" placeholder="First Name">
                        
                            <div id="last_name_alert" class="text-danger"> </div>
                            <input type="text" class="form-control mb-3 StripeElement--empty"  pattern="[a-zA-Z ]*" id="last_name" name="last_name" placeholder="Last Name">

                            <div id="delivery_address_alert" class="text-danger"> </div>
                            <textarea cols="3" placeholder="Delivery address" class="form-control mb-3 StripeElement--empty" pattern="['a-zA-Z0-9 ]*'" id="delivery_address"  name="delivery_address" ></textarea>

                            <div id="postcode_alert" class="text-danger"> </div>
                            <input type="text" class="form-control mb-3 StripeElement--empty" minlength="6" maxlength="8" title="Up to 8 Characters" pattern="[a-zA-Z0-9 ]*" name="postcode" id="postcode" placeholder="Postcode">
                            
                            <div id="phone_number_alert" class="text-danger"> </div>
                            <input type="tel" class="form-control mb-3 StripeElement--empty" name="phone_number"  title="Number must start with 0 and be 10-11 digits" minlength="10" maxlength="11" pattern="^[0-9]*" id="phone_number" placeholder= "Phone Number">
                            
                            <div id="email_alert" class="text-danger"> </div>
                            <input type="email" class="form-control mb-3 StripeElement--empty" id="email" name="email" placeholder="Email Address">

                            
                            <!-- Used to display form errors. -->
                            <div class="text-danger" id="card-errors" role="alert"></div>
                            
                            <div class="form-control" id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                            </div>

                        </div>

                        <button>Submit Payment</button>
                    </form>
            
                </div>
            </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="./js/charge.js"></script>

<?php require_once "includes/footer.php"; ?>