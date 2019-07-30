<?php
        
class Transaction
{
            
    private $db;

    private $this_year = "";
    private $last_year = "";
    private $this_month ="";
    private $next_month ="";
    private $last_month ="";
    private $todays_date = "";
    
    private $default_date_time = "";
    private $current_time_and_date = "";  

    private $chosen_month = "";
    private $chosen_month_as_string = "";
    private $chosen_year = "";

    private $chosen_transaction = "";

    private $id_to_update;

/////////////////////  CONSTRUCTOR  ////////////////////////////////////       
    public function __construct()
    {
        $this->db = new Database;

        $this->this_year = date('Y');
        $this->last_year = $this->this_year - 1;
        $this->this_month = date('m');
        $this->next_month = $this->this_month + 1;
        $this->last_month = $this->this_month - 1;
        $this->todays_date = date('Y-m-d');
        $this->current_time_and_date = date('Y-m-d H:i:s');
        $this->default_date_time = '2000-01-01 00:00:00';

    
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
            elseif(!isset($_GET['transaction_id']) && !isset($_GET['month']) && basename($_SERVER['PHP_SELF']) == "transactions.php")  // show choose a month
            {
                    require_once "includes/transaction_choose_month.php";
            }
            elseif(isset($_GET['transaction_id'])) // show specific transaction/order
            {
                    $this->chosen_transaction = filter_var($_GET['transaction_id'],FILTER_SANITIZE_STRING);
                    require_once "includes/transaction_view_selected.php";
            }
            elseif(isset($_GET['order_ready']) && $_GET['order_ready'] == "yes")
            {
                    if(isset($_GET['order_id']))
                    {
                        $this->id_to_update = filter_var($_GET['order_id'],FILTER_SANITIZE_STRING);
                        
                        $this->mark_order_as_ready($this->id_to_update);
                    }
                
            }
            elseif(isset($_GET['order_dispatched']) && $_GET['order_dispatched'] == "yes")
            {
                    if(isset($_GET['order_id']))
                    {
                        $this->id_to_update = filter_var($_GET['order_id'],FILTER_SANITIZE_STRING);
                        
                        $this->mark_order_as_dispatched($this->id_to_update);
                    }
                
            }
                
    }

////////////////////// CRUD ////////////////////////////////////

//create

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

// read          
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
            echo "
                <tr>
                    <td>a$result->id</td>
                    <td>$result->customer_id</td>
                    <td>£$result->amount </td>
                    <td>$pretty_date </td>
                    <td> <a class='btn btn-dark btn-sm' href='transactions.php?transaction_id=$result->id'> view </a> </td>
                </tr>";
        }
    
    }
            
            
    /// show month loops           
    public function show_this_year_month_cycle()
    {        

            for($i = 1; $i <= $this->this_month; $i++)
            {
                
                $dt = DateTime::createFromFormat('!m',$i); 
                if($this->this_month == $i)
                {
                    echo "
                        <tr>
                            <td>  <a class='month active' href='transactions.php?month=$i&year=$this->this_year'>".$dt->format('F')."</a>  </td>
                            <td> £".$this->get_monthly_transactions_total($i,$this->this_year)." </td>
                        </tr>";   
                }
                else
                {
                    echo " 
                        <tr>
                            <td> <a  class='month' href='transactions.php?month=$i&year=$this->this_year'>".$dt->format('F')."</a>   </td>
                            <td> £".$this->get_monthly_transactions_total($i,$this->this_year)." </td>
                        </tr> ";   
                } 
        
            } 

    }

    /// show month loops (last year)                
    public function show_last_year_month_cycle()
    {       
            for($i = 1; $i <= 12; $i++)
            {
                $dt = DateTime::createFromFormat('!m',$i);

                echo "
                    <tr> 
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
            $total = number_format($total,2);
            $item_name = $item['name'];
            $item_price = $item['price'];
            $item_quantity = $item['quantity'];

            echo "
                    <b>Item name:</b> $item_name <br> 
                    <b>Unit Price:</b>£$item_price <br>
                    <b>Quatity Ordered:</b>  $item_quantity <br>
                    <b>Total:</b>£$total <br> <hr>";
        }
    
    }

////////////////////                           /////////////////////////////////
                 // for live orders admin index
                
    public function get_orders_for_the_day()
    {
        $this->db->query("SELECT * FROM customers LEFT JOIN transactions ON transactions.customer_id = customers.id  WHERE DATE(created_at) = :todays_date AND 
        DATE(order_dispatched_at) = :default_date_time ORDER BY created_at DESC ");

        $this->db->bind("todays_date",$this->todays_date);
        $this->db->bind("default_date_time",$this->default_date_time);
            
        $results = $this->db->resultset();

            if($this->db->rowCount() == 0)
            {
                echo "<h2 class='text-center text-danger'> Nothing to show Here. We have not had any orders yet for today. </h2>";
            }
            else
            {
                foreach($results as $result)
                {
                    $full_name = $result->first_name. " ". $result->last_name;

                    // for time order was placed
                    $date_format = DateTime::createFromFormat('Y-m-d H:i:s',$result->created_at);
                    $get_time_as_hours = $date_format->format('H:i:s');

                    // for time order was made and ready to go
                    if($result->order_ready_at == $this->default_date_time)
                    {
                        $is_order_ready = " <span class='text-danger'> Not Ready! </span>  <br>
                        <a href='index.php?order_ready=yes&order_id=$result->id' class='float-right btn btn-sm btn-success'>Mark as Ready </a> <br>";
                    }
                    else
                    {
                        $order_time_format = DateTime::createFromFormat('Y-m-d H:i:s',$result->order_ready_at);
                        $order_time_format = $order_time_format->format('H:i:s');
                        $is_order_ready = "<span class='text-success'> Yes.. Order has been ready since </span> <br> ". $order_time_format;
                    }

                    // for time order was dispatched to customer
                    if($result->order_dispatched_at == $this->default_date_time)
                    {
                        $is_order_sent = "<span class='text-danger'> Not Been Delivered Yet! </span>  <br> <br>
                        <a href='index.php?order_dispatched=yes&order_id=$result->id' class='float-right btn btn-sm btn-success'>Mark as out for delivery </a> <br> ";
                    }

                    $total_items_ordered = 0;
                    $counter = 0;
                      
                    $items = json_decode($result->items_ordered,true);

                    echo "
                        <div class='text-center'>
                            <h3 class='text-danger'> <u> New Order </u> </h3>
                                <div class='row'>
                                
                                    <div class='col-sm-4'>
                                            <h6> <u> Items Ordered </u> </h6>
                    
                                            <table class='ml-3'>
                                                <thead>
                                                    <th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                </thead>
                                                <tbody>";
                                                
                                                foreach($items as $item)
                                                {
                                                        
                                                    $item_name = $item['name'];
                                                    $item_quantity = $item['quantity'];
                                                    $total_items_ordered += $item_quantity;
                                                    $counter++; 
                                                    
                                                    echo "<tr>
                                                            <td><b>$counter </b>.<b> </b></td>
                                                            <td>$item_name</td>
                                                            <td>$item_quantity</td>
                                                        </tr>"; 
                                                
                                                }
                    
                                                echo "</tbody>
                                                
                                                </table>  <br>
                                                    <div class='float-left'> <b >Total Amount of items: </b>  $total_items_ordered </div>   
                                    </div>
                                        
                                    <div class='col-sm-4'>
                                        <h6> <u>  Delivery Address </u> </h6>
                                        
                                        <b class='float-left'> Name:</b> $full_name  <br>
                                        <b class='float-left'>Address:</b> $result->delivery_address <br>
                                        <b class='float-left'>Postcode:</b> $result->postcode <br>
                                        <b class='float-left'>Phone Number: </b> $result->phone_number  

                                    </div>
                                        
                                    <div class='col-sm-4'>
                                        <h6> <u>  Dispatch time </u> </h6>
                                        <b class='float-left'> Order Placed at:</b> $get_time_as_hours  <br>
                                        <b class='float-left'>Order status:</b>  $is_order_ready   <br>  <br> 
                                        <b class='float-left'>Delivery status:</b>  $is_order_sent  <br>
                                    </div>

                                </div>
                        </div> <br> <hr>";
                }
            }
        
    }

/// update (mark order as dispatched or ready )
    public function mark_order_as_ready($id)
    {
    
        $this->db->query("UPDATE transactions SET order_ready_at = :time_order_was_ready WHERE id = :id ");
        
        $this->db->bind("time_order_was_ready",$this->current_time_and_date);
        $this->db->bind("id",$id);
        
        if($this->db->execute())
        {
            header("location: index.php");
        }
        else
        {
            return false;
        }
    }

    
    public function mark_order_as_dispatched($id)
    {
        $this->db->query("UPDATE transactions SET order_dispatched_at = :time_order_was_dispatched WHERE id = :id ");
        
        $this->db->bind("time_order_was_dispatched",$this->current_time_and_date);
        $this->db->bind("id",$id);
        
        if($this->db->execute())
        {
            header("location: index.php");
        }
        else
        {
            return false;
        }
    }

}