<?php

class Orders{

    private $db;
    
   

    public function __construct()
    {
        $this->db = new Database;

    }





        



    // if(isset($_GET['order_id'])){
    //     $order_id = mysqli_real_escape_string($connection,$_GET['order_id']); 
    //   };
      
  
    //   $query = " SELECT * FROM orders WHERE id = $order_id " ;
    //   $result = mysqli_query($connection,$query);
    //   if(!$result){die("orders result failed".mysqli_error($connection));}
    //   $row = mysqli_fetch_assoc($result);
    //   $id = $row['id'];
    //   $customer_details = json_decode($row['customer_details'],true);
      
    //   $ordered_items = json_decode($row['ordered_items'],true);
      
    //   $total_paid = $row['total_paid'];
    //   $order_date = $row['order_date'];
      
    //  // convert date to string so we can get the month and year below
    //   $date_as_string = strtotime($order_date);
  
    //   // get date and year value  so it can be used in $_GET direct us back to the right page once dispatch status has been changed
    //   $month_of_order = date("m",$date_as_string);
    //   $year_of_order = date("Y",$date_as_string);
  
     
    //   $order_dispatched = $row['order_dispatched'];
    //   $dispatch_date = $row['dispatch_date']; 
    //   
  
    //   <h3 class="text-center order_title">Order number <?= $order_id   </h3>
  
    //   <?php
    //   // get the address
    //   
    //   <div class="row">
       
    //       <div class="col md-4">
          
    //           <h4> Order details </h4> 
    //           <?php
    //       // get the order
    //           $i = 1;
    //           foreach($ordered_items as $items){
    //           echo "#".$i; echo "<br>";
    //           echo "id = "; echo $items['product_id']; echo "<br>";
    //           echo "name = "; echo $items['title']; echo "<br>";
    //           echo "size = "; echo $items['size']; echo "<br>";
    //           echo "quantity = "; echo $items['quantity']; echo "<br> <br>";
    //           $i++;
    //           ;} 
  
    //       </div>
  
    //       <div class="col md-4">
    //           <h4> Delivery Address</h4>
    //           <?php
    //               foreach($customer_details as $details){
    //               echo  $details; echo "<br>";
    //               ; }   
    //       </div>
  
    //       <div class="col md-4">
    //           <h4>Order summary</h4> <?php
  
    //               // order summary
    //               echo "Total Paid: £". $total_paid. "<br>"; 
    //               echo "Order Date: ". $order_date. "<br> <br>  "; 
  
    //               <h6 class="text-center"> Delivery Status</h6> <?php
    //               // sent status
    //                   if($order_dispatched == 0){ 
    //                      <b> Status:   </b>  <span class="text-danger"> Not sent </span>  <br>  
    //                             <a class="btn btn-primary" href="orders.php?source=view_monthly&month=<?=$month_of_order&year=<?=$year_of_order&dispatched=yes&dispatch_id=<?= $id "> Mark as sent </a>
    //                         <?php }else{ Status:  <span class="text-success">  Dispatched </span><br>  <br> 
    //                             <a class="btn btn-primary" href="orders.php?source=view_monthly&month=<?=$month_of_order&year=<?=$year_of_order&dispatched=no&dispatch_id=<?= $id "> Change to not sent </a>
  
    //                        <?php } 
    //                      <br> <br>
    //                      <b> Date order was sent: </b>  <span 
    //                      <?php if($dispatch_date == "Not sent"){class="text-danger" <?php   > <?= $dispatch_date   <?php } 
                        
    //                      </span>  <br> <br>
    //                   <a class="btn btn-lg btn-dark" href="orders.php?source=view_monthly&month=<?=$month_of_order&year=<?=$year_of_order"> Go back </a>
  
    //      </div>
  
    //   </div>




// // update order dispatched
// $date_sent = date("Y-m-d H:i:s");  
// $reset_date_sent = "Not sent";  
// $sent = 1;
// $not_sent = 0;
// if(isset($_GET['dispatched'])){
//    $dispatched = $_GET['dispatched'];

//    $id_to_update = $_GET['dispatch_id'];

//     if($dispatched == "yes"){
//         $stmt = mysqli_stmt_init($connection);   
//         $query = "UPDATE orders SET order_dispatched = ?, dispatch_date = ? WHERE id = ? " ;
        
//         if(!mysqli_stmt_prepare($stmt,$query)){
//         die("dispatch prep failed".mysqli_error($connection));   
//         }

//         if(!mysqli_stmt_bind_param($stmt,"isi",$sent,$date_sent,$id_to_update)){
//             die("dispatch bind failed".mysqli_error($connection));   
//         }

//         if(!mysqli_stmt_execute($stmt)){
//             die("dispatch execute failed".mysqli_error($connection));   
//         }

//         mysqli_stmt_close($stmt);
//         header("Location: orders.php?source=view_monthly&month=$selected_month&year=$selected_year");
//     }  


//     if($dispatched == "no"){
//         $stmt = mysqli_stmt_init($connection);   
//         $query = "UPDATE orders SET order_dispatched = ?, dispatch_date = ? WHERE id = ? " ;
        
//         if(!mysqli_stmt_prepare($stmt,$query)){
//         die("dispatch prep failed".mysqli_error($connection));   
//         }

//         if(!mysqli_stmt_bind_param($stmt,"isi",$not_sent,$reset_date_sent,$id_to_update)){
//             die("dispatch bind failed".mysqli_error($connection));   
//         }

//         if(!mysqli_stmt_execute($stmt)){
//             die("dispatch execute failed".mysqli_error($connection));   
//         }

//         mysqli_stmt_close($stmt);
//         header("Location: orders.php?source=view_monthly&month=$selected_month&year=$selected_year");
//     } 







    // public function view_orders_by_year($year)
    // {
    //     $this->db->query("SELECT * FROM orders WHERE year ")


    // }
    
    // public function view_orders_by_month($month)
    // {
    //     $this->db->query("SELECT * FROM")



    // }










}














