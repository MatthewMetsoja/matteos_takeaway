<?php
require_once ("../config/pdo_db.php");
require_once ("../vend_load.php");
require_once ("includes/head.php");
require_once ("includes/active_class.php");
require_once ("../models/Transaction.php");
require_once ("includes/navigation.php");
$transactions = new Transaction;

?>



        </div>
    </div>
</div>


<?php require_once ("includes/footer.php"); ?>