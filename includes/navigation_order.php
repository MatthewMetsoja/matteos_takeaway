    <nav id=""  class="nav navbar fixed-top">
        <a class="navbar-brand"id="back_to_menu_link"  href="index.php"> 
            Back to Menu  <i  class="fas fa-home"> </i>  
        </a>
            <?php 
            Basket::show_success_flash();
            Basket::show_error_flash(); 
                        
            if(isset($_SESSION['id']))
            { ?>
                <li class="nav-item">
                    <a  class="nav-link" href="admin/index.php">Admin  <i  class="fas fa-cog"></i> </a>
                </li>
            
                <li class="nav-item">
                    <a  class="nav-link" href="log_out.php">Log out  <i class="fas fa-power-off    "></i> </a>
                </li> <?php
            } ?> 


            <div class="text-center">
                    <img id="kfs_order_nav" src="./images/main_logo.png"  alt="01235 343234" >
            </div>
                    
            <?php 
            if($order->basket_price_nav() !== "0.00")
            { ?> 
                <a  href="payment_page.php" id="onto_payment_btn" class="btn btn-sm btn-success">
                        <i class="fas fa-pizza-slice"></i> On to payment <span> £<?= $order->basket_price_nav(); ?> </span> 
                </a> <?php 
            } ?>
                        
    </nav>

</header>
    
