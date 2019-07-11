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
        

}