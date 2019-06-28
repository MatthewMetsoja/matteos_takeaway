<?php
require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "includes/head.php";

// if(!isset($_GET['staff']) || $_GET['staff'] !== "login"){
// header("location: index.php");
// }

?>

<nav id=""  class="nav navbar fixed-top">
    <a class="navbar-brand"id="back_to_menu_link"  href="index.php"> 
        Back to Menu  <i  class="fas fa-home"> </i>  
    </a>
                  
                   <div class="text-center">
                        <img id="kfs_order_nav" src="./images/main_logo.png"  alt="01235 343234" >
                   </div>
                  
              <a id="our_number_nav_link" class="nav-link">  01235 343234 </a> 
                       

</nav>

    </header>
    



<div class="container" id="login_contain">
    <div class="row">
        <div class="col-sm-12">
            
                    
        <div id="login_title"> <h1 class="text-center">  Staff Login</h1>  </div>

            <div class="row">
                <div class="col-1"></div>
                
                <div class="col-10">
                 <div id="login_form">
                    <form method="post" action="">
                                <div class="form-group row">
                                    <label for="number" class="col-sm-12 col-form-label">Email</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" pattern="[0-9]* "name="staff_number" placeholder="Please enter staff number">
                                    </div>
                                </div>
                          
                                <div class="form-group row">
                                    <label for="number" class="col-sm-12 col-form-label">Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="inputName" id="inputName" placeholder="Please enter staff number">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-block btn-success">Login</button>
                              
                        </form>
                    </div>   
                </div>

                <div class="col-1"></div>
           </div>


        </div>
    </div>
</div>



<?php require_once("includes/footer.php"); ?>