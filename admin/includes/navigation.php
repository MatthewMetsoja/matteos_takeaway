<?php
 if(!isset($_SESSION['id']))
 {
     header("location: ../index.php"); 
 } ?>
<nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top">
    <a href="../index.php" class="navbar-brand"><i class="fas fa-home    "></i> Public Home Page</a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
 
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?= $adminHomePageClass ?>" href="index.php"><i class="fas fa-cog"></i> Real time live orders</a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link <?= $transactionsPageClass ?>" href="transactions.php"> <i class="fas fa-money-bill-wave"></i> Transactions</a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link <?= $productsPageClass ?>" href="menu.php"> <i class="fa fa-book" aria-hidden="true"></i> </i> Menu </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link <?= $staffPageClass ?>" href="staff.php"> <i class="fas fa-users-cog"></i>  Staff</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../log_out.php"><i class="fas fa-power-off    "></i> Log out</a>
            </li>
        </ul>
    </div>
</nav>

</header>