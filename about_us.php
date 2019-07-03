<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Menu.php";
require_once "models/Basket.php";
require_once "includes/head.php";
$order = new Basket;
require_once "includes/navigation_about_us.php";


?>
 <div id="main_menu_div" data-spy="scroll" data-target="" data-offset="100">
                <span class="anchor" id="contact"></span>

  <div id="about_us_jumbo" class="jumbotron jumbotron-fluid">
        <div id="jumbo_belly"> 
            <h1 id="order_title" class="it">About us </h1>
  
                <p id="about_us_intro" class="lead text-center"> 
                 <br>
                 Here at Matteos Takeaway we serve authentic tasty food straight to your door. We offer hot and cold starters, a wide variety of pasta dishes, delicious main courses,
                  and a great selection of pizzas. We aim to bring a taste of Italy to you at your home with in one hour of you your placing your order.
                  If you would prefer to to collect your order yourself in person instead of having it delivered then please call us on <b> 01235 343234 </b> and place your order over the phone. 
                   We are located in the centre of town, Please see the map below for directions.
                </p>

      
        </div> 
  </div>

<div class="container-fluid" id="order_contain" >



    <div class="row">
    <div id="" class="col-sm-2"></div>  
      <div id="" class="col-sm-8">
      
           <h3 id="check_order_title" class="menu_title"> <b>  <u> Directions </u>   </b> </h3>
                    
           <iframe class="frame" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8660.591954676374!2d-1.9409424145199183!3d51.71061770446676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1562082063291!5m2!1sen!2suk" width="800" height="600" frameborder="1"  allowfullscreen></iframe>


           
                
             
            </div>
            <div id="" class="col-sm-2"></div>  
        </div>
    </div>



<?php require_once "includes/footer.php"; ?>