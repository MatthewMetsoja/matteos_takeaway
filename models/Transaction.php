<?php
        
        class Transaction{
            
            private $db;

            private $this_year = "";
            private $last_year = "";
            private $this_month ="";
            private $next_month ="";
            private $last_month ="";
        
            private $chosen_month = "";
            private $chosen_month_as_string = "";
            private $chosen_year = "";

            private $chosen_transaction = "";

            public function __construct()
            {
                $this->db = new Database;


                $this->this_year = date('Y');
                $this->last_year = $this->this_year - 1;
                $this->this_month = date('m');
                $this->next_month = $this->this_month + 1;
                $this->last_month = $this->this_month - 1;
        
             
        
                // show monthly transactions for selected month
                if(isset($_GET['month']))
                {
                     $this->chosen_month = filter_var($_GET['month'],FILTER_SANITIZE_STRING);

                     // covert date to string value for header title
                     $date_format = DateTime::createFromFormat('!m',$this->chosen_month);
                     $this->chosen_month_as_string = $date_format->format('F');
                     
                     if(isset($_GET['year']))
                     {
                         $this->chosen_year = filter_var($_GET['year'],FILTER_SANITIZE_STRING);
                     }

                     require_once "includes/transaction_month_view.php";
                }
                // show choose a month
                elseif(!isset($_GET['transaction_id']) && !isset($_GET['month']) && basename($_SERVER['PHP_SELF']) == "transactions.php")
                {
                    require_once "includes/transaction_choose_month.php";
                }
                // show specific transaction/order
                elseif(isset($_GET['transaction_id']))
                {
                    $this->chosen_transaction = filter_var($_GET['transaction_id'],FILTER_SANITIZE_STRING);
                    require_once "includes/transaction_view_selected.php";
                }

           
            }


            public function addTransaction($data)
            { //Prepare query
                $this->db->query("INSERT INTO transactions (id, customer_id, items_ordered, amount, status) 
                VALUES( :id, :customer_id, :items_ordered, :amount, :status) " ); 

             //Bind Values
                $this->db->bind(':id', $data['id']);
                $this->db->bind(':customer_id', $data['customer_id']);
                $this->db->bind(':items_ordered',$data['items_ordered']);
                $this->db->bind(':amount', $data['amount']);
                $this->db->bind(':status', $data['status']);

             // Execute 
                    if($this->db->execute())
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }

            }


            
            public function getTransactions()
            {

                $this->db->query('SELECT * FROM transactions ORDER BY created_at DESC ');

                $results = $this->db->resultset();

                return $results;

            }



            public function get_monthly_transactions($month,$year)
            {
                $this->db->query("SELECT * FROM transactions WHERE YEAR(created_at) = :chosen_year AND MONTH(created_at) = :chosen_month ORDER BY created_at DESC ");   
                $this->db->bind(":chosen_month",$month);
                $this->db->bind(":chosen_year",$year);
                
                return $this->db->resultset();
    
            }

            public function get_monthly_transactions_total($month,$year)
            {
                $results = $this->get_monthly_transactions($month,$year);

                $monthly_sales_total = 0;
                
                foreach($results as $result)
                {
                   $monthly_sales_total += number_format($result->amount,2);
                }

                return number_format($monthly_sales_total,2);
    
            }

            
            public function show_transactions_for_chosen_month($month,$year)
            {       
                $results = $this->get_monthly_transactions($month,$year);

                

                foreach($results as $result)
                {
                    $pretty_date = date('d-M-Y H:i:s',strtotime($result->created_at));
                    echo "<tr>
                            <td>a$result->id</td>
                            <td>$result->customer_id</td>
                            <td>£$result->amount </td>
                            <td>$pretty_date </td>
                            <td> <a class='btn btn-dark btn-sm' href='transactions.php?transaction_id=$result->id'> view </a> </td>
                            </tr>";
                }
            
            }
            
            
            
            public function show_this_year_month_cycle()
            {        
        
                    for($i = 1; $i <= $this->this_month; $i++)
                    {
                       
                        $dt = DateTime::createFromFormat('!m',$i); 
                        if($this->this_month == $i)
                        {
                          echo "<tr>
                                  <td>  <a class='month active' href='transactions.php?month=$i&year=$this->this_year'>".$dt->format('F')."</a>  </td>
                                  <td> £".$this->get_monthly_transactions_total($i,$this->this_year)." </td>
                               </tr>";   
                        }
                        else
                        {
                          echo " <tr>
                                 <td> <a  class='month' href='transactions.php?month=$i&year=$this->this_year'>".$dt->format('F')."</a>   </td>
                                 <td> £".$this->get_monthly_transactions_total($i,$this->this_year)." </td>
                                 </tr> ";   
                        } 
                
                    } 
        
        
            }
                    
                public function show_last_year_month_cycle()
                {       
                        for($i = 1; $i <= 12; $i++)
                        {
                            $dt = DateTime::createFromFormat('!m',$i);
        
                            echo "<tr> 
                                   <td>  <a class='month' href='transactions.php?month=$i&year=$this->last_year'>".$dt->format('F'). "</a>   </td>  
                                   <td> £".$this->get_monthly_transactions_total($i,$this->last_year)." </td>
                                  </tr>";    
                               
                        }   
                
                }


                public function get_chosen_transaction($chosen_transaction_id)
                {
                    $this->db->query("SELECT * FROM transactions LEFT JOIN customers ON customers.id = transactions.customer_id WHERE transactions.id = :chosen_id");
                    $this->db->bind("chosen_id",$chosen_transaction_id);
                    $result = $this->db->single();
                    return $result;
                }

                public function get_chosen_transaction_items_ordered($chosen_transaction_id)
                {
                    $result = $this->get_chosen_transaction($chosen_transaction_id);

                    $items_ordered = json_decode($result->items_ordered,true);
                    
                    foreach($items_ordered as $item)
                    {
                        $total = $item['price'] * $item['quantity'];
                        $item_name = $item['name'];
                        $item_price = $item['price'];
                        $item_quantity = $item['quantity'];

                        echo "
                              <b>Item name:</b> $item_name <br> 
                              <b>Unit Price:</b>  $item_price <br>
                              <b>Quatity Ordered:</b>  $item_quantity <br>
                              <b>Total:</b>£$total <br> <hr>";
                    }
                
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