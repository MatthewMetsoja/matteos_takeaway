<div class="container-fluid">
    <div class="row">
        <div class="col sm-12">
            <h1 class="text-center mb-2">  <a href="transactions.php">  <i class="fas fa-money-bill-wave"> </i> Transactions  </a>  </h1>
           
           <h5 class='text-center'> View Transaction () </u> </h5>
           <div class='row'>  
             <div class="col-sm-4">
                <h6 class="text-center"> <u> Order details </u> </h6>
                <b> ID:  </b> <?= $this->chosen_transaction ?>  <br>
                <b> Customer Id:</b> <?= $this->get_chosen_transaction($this->chosen_transaction)->customer_id ?>     <br>
                <b> Total: </b>   £<?= $this->get_chosen_transaction($this->chosen_transaction)->amount ?>          <br>
                <b> Time & Date:</b> <?= $this->get_chosen_transaction($this->chosen_transaction)->created_at ?>        <br>
            </div>  
            <div class="col-sm-4">
                 <h6 class="text-center"> <u> Customer Details </u> </h6>
                 <b> Customer Name: </b>  <?= $this->get_chosen_transaction($this->chosen_transaction)->first_name." ".$this->get_chosen_transaction($this->chosen_transaction)->last_name; ?>      <br>
                 <b> Delivery Address:</b>  <?= $this->get_chosen_transaction($this->chosen_transaction)->delivery_address; ?>      <br>
                 <b> Postcode: </b> <?= $this->get_chosen_transaction($this->chosen_transaction)->postcode; ?>     <br>
                 <b> Email: </b>  <?= $this->get_chosen_transaction($this->chosen_transaction)->email ; ?>   <br>
                 <b> Contact: </b> <?= $this->get_chosen_transaction($this->chosen_transaction)->phone_number ;?>    <br>
            </div>  
            <div class="col-sm-4">
                <h6 class="text-center"> <u> Items ordered </u> </h6>
                <?= $this->get_chosen_transaction_items_ordered($this->chosen_transaction) ;?>  
            </div>  
          
          </div> 
    </div>
</div>