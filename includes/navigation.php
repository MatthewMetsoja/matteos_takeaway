<nav id="the_spy"  class="nav navbar fixed-top">

                    <?php Basket::show_success_flash(); ?>
                    <?php Basket::show_error_flash(); ?>

                    <li class="nav-item">
                        <a  class="nav-link" href="#contact">Contact Us <span id="phone_sign" > <i  class="fas fa-phone"> </i>  </span> </a>
                    </li>
                    <li class="nav-item">
                        <a id="starters_link" class="nav-link" href="#starters">Starters </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pizza">Pizza</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pasta">Pasta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rissoto">Rissoto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#grill">Fish & Grill</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sides">Sides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#deserts">Deserts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#drinks">Drinks</a>
                    </li>
                  
                   <?php if(isset($_COOKIE[getenv(SEC_BASKET_COOKIE)])){?>  <a  href="order.php" id="checkout_btn" class="btn btn-sm btn-success"> <i class="fas fa-pizza-slice"></i> Check order  <?= $basket->basket_count_nav() ?> </a> <?php } ?>
                  

             

</nav>

    </header>
    