<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Menu.php";
require_once "models/Basket.php";
require_once "includes/head.php";
$menu = new Menu;
$basket = new Basket;
require_once "includes/navigation.php";

?>
 <div id="main_menu_div" data-spy="scroll" data-target="the_spy" data-offset="0">
                <span class="anchor" id="contact"></span>
             <section id="contact" class="active"> 
  <div id="main_jumbo" class="jumbotron jumbotron-fluid">
        <div id="jumbo_belly"> 
            <h1 id="payment_title" class="it">Welcome to Matteo's Italian Takeaway </h1>
            
           <h2 class="text-center">  <img id="kfs_logo" src="./images/main_logo.png"> </h2>
                <p id="jumbo_intro_text" class="lead text-center"> 
                Matteo and the team are ready to give you the true italian experience with
                a mouth-watering selection of pasta dishes, risotto, various meat and fish dishes.
                For desert why not try our famous gelato. Please click on the item you fancy to add it to
                   your basket, we aim to deliver your meal to you within an hour. <br>
                
                </p>

              
                <h5 class="text-center">  <img class="jumbo_icon_phone" src="images/icons/phone_icon.png" alt="">  Contact us on - <b> 01235 343234 </b> - To Place an Order - 
                Or you can Place your Order Online and get an extra 5% off 
              </h5>
         
           
            <div class="text-center" id="jumbo_intro_2" >
           
            <h4 class="text-center"> <u> Opening Times </u>  </h4>
                <b> Monday - Thursday 11:30am to 22:00 </b> <br>    
                <b> Friday - Saturday 11:30am to 23:00 </b> <br>   
                <b> Sunday 11:30am to 22:00 </b> <br>
               
              
                </div> 
           <p class="text-center"> 
                <a href="">Please Click here for directions and for more info about our history <br>  </a>
          </p>

          </div>
      
  </div>



<div class="container-fluid">
    <div class="row">
        <div id="menu" class="col-sm-12">
        
      
        <h3 id="main_menu_title" class="menu_title"> <b> <u>  Menu </u>  </b> </h3>
        <div class="text-center veg_nut"  >   <span class="text-success"> (V) </span> denotes vegetarian dishes
        <span class="text-danger">  (N) </span> denotes nuts or traces of nuts </div>
        
        
          </section>
      <form action="" method="" id="add_product_form"> 
            <section> 
            <span class="anchor" id="starters"></span>
            <h4 class="menu_title" >Starters</h4>
            <div class="text-center"> <img class="menu_icon" src="images/icons/garlic_bread_icon.png" alt=""> </div>
            
            <div class="row">
            <div class="col-6 text-center">
          
             <?php $menu->showMenu(1); ?>   
            

            </div>
             </div>

             </section>
             
             <span class="anchor" id="pizza"></span>
             <section id="pizza"> 
            <h4 class="menu_title">Pizza</h4>
            <div class="text-center"> <img class="menu_icon" src="images/icons/pizza_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(2); ?>   
         

      
          </div>
            </section>

            <span class="anchor" id="pasta"></span>
             <section id="pasta"> 
            <h4 class="menu_title">Pasta</h4>
            <div class="text-center"> <img class="menu_icon" src="images/icons/bolonaise_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(3); ?>   
         

      
          </div>
             </section>

             <span class="anchor" id="rissoto"></span>
             <section id="rissoto"> 
            <h4 class="menu_title">Rissoto</h4>
            <div class="text-center"> <img class="menu_icon" src="images/icons/risotta_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(4); ?>   
         

      
          </div>
            </section>

            <span class="anchor" id="grill"></span>
             <section id="grill"> 
             <h4 class="menu_title">Fish & Grill</h4>
             <div class="text-center"> <img class="menu_icon" src="images/icons/grill_icon.png" alt=""> </div>
             <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(5); ?>   
         

      
          </div>
          
            </section>

            <span class="anchor" id="sides"></span>
             <section id="sides"> 
            <h4 class="menu_title">Sides</h4>
            <div class="text-center"> <img class="menu_icon" src="images/icons/pasta_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(6); ?>   
         

      
          </div>
            </section>


            <span class="anchor" id="deserts"></span>
             <section id="deserts"> 
            <h4 class="menu_title">Deserts</h4>
            <div class="text-center"> <img class="menu_icon_cake" src="images/icons/desert_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
          <?php $menu->showMenu(7); ?>   
         

      
          </div>
             </section>
             
             <span class="anchor" id="drinks"></span>
             <section id="drinks"> 
            <h4 class="menu_title">Drinks</h4>
            <div class="text-center"> <img class="menu_icon_drink" src="images/icons/drinks_icon.png" alt=""> </div>
            <div class="row">
            <div class="col-6 text-center">
          
           <?php $menu->showMenu(8); ?>   
         

      
          </div>
             </section>
      </form>
            
            </div>

        </div>
    </div>



<?php require_once "includes/footer.php"; ?>