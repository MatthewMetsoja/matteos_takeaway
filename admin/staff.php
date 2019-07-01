<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("../models/Staff.php");
require_once ("includes/active_class.php");
require_once ("includes/navigation.php");

Staff::delete_staff_member_verification();  
?>

<div class="container-fluid">
<div class="alert-danger text-danger"> <?= Staff::$delete_error_message ?> </div>
 
<div class="row">
        <div class="col sm-12">
            <h1 class="text-center mb-3"> <a href="staff.php">  <i class="fas fa-users-cog"></i>  Staff  </a>  </h1>
            <?php   if(!isset($_GET['add_member']) && (!isset($_GET['edit_member']) )  )
                    { ?>   
                        <div class="text-center mb-3">  <a href="staff.php?add_member=yes" class="btn btn-success">Click here to Add new staff member</a> </div> 
                        <div class="alert-danger text-danger"> <?= Staff::$delete_error_message ?> </div>
                      <?php          
                    } ?>       
        </div> 
    </div>     
    <div class="row">   
        <div class="d-none d-sm-block col-1"> </div>  
       
        <div class="col-sm-10">  
           <?php $staff = new Staff; ?>
          
        </div> 

        <div class="d-none d-sm-block col-1"> </div>  

    </div>

    <div class="alert-danger text-danger text-center"> <?= Staff::$delete_error_message ?> </div>
   
</div>


<?php require_once "includes/footer.php";
