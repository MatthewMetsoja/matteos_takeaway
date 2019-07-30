<div class="container">
    <div class="row">
        <div class="col sm-12">
            <h1 class="text-center mb-2">  <a href="transactions.php">  <i class="fas fa-money-bill-wave"> </i> Transactions  </a>  </h1>
           
            <h5 class='text-center'> <u> All transactions from <?= $this->chosen_month_as_string. " ".$this->chosen_year ?> </u> </h5>
            <div class='row'>
                <table class="table table-inverse">
                    <thead>
                        <th> <u> Id </u> </th>
                        <th> <u> Customer Id </u> </th>
                        <th> <u> Total </u> </th>
                        <th> <u> Purchase date </u></th>
                        <th> <u> View </u></th>
                    </thead>
                    
                    <tbody>
                        <?php $this->show_transactions_for_chosen_month($this->chosen_month,$this->chosen_year); ?>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>