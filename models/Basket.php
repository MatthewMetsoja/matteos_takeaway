<?php

class Basket
{
   private $db; 

   private $order_id = "";
   private $basket_id = "";

   private $id;
   private $name;
   private $price;
   private $quantity = 1;
   private $basket_items_array;

   private $new_basket_items = array();

   private $basket_total_price;
   private $basket_total_count;
   private $basket_discount;
   private $basket_total_price_minus_discount;

   public static $error_flash;
   public static $success_flash;

   private $json_basket_with_new_item;

   // create variable to see if items match and set it to false
   private $item_match = 0;
   
     
//////////////////////////////////  CONSTRUCTOR //////////////////////////  
      public function __construct()
      {
         // define cookie constants
         self::define_cookie();

         $this->db = new Database;

      
            if(isset($_POST["id"]))       /// insert new basket or add one to quantity call 
            {
               
                  $this->id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
                  isset($_POST['name']) ? $this->name = filter_var($_POST['name'],FILTER_SANITIZE_STRING) : $this->name = FALSE;
                  isset($_POST['price']) ? $this->price = filter_var($_POST['price'],FILTER_SANITIZE_STRING) : $this->price = FALSE; 
               
                  // set a new array that for posted item that will sent into query below 
                  $this->basket_items_array = array();
                  
                  $this->basket_items_array[] = array(
                     
                     "id" => $this->id ,
                     "name" => $this->name,
                     "price" => $this->price ,
                     "quantity" => $this->quantity
                     
                  );
                  
                     // run methods
                  $this->does_basket_exist();
            } 
            else if(isset($_POST["minus_id"])) // take one from quantity or remove item from basket call we dont need array now as new items are not being added
            {
                  // set id so we can search for a match
                  $this->id = filter_var($_POST['minus_id'],FILTER_SANITIZE_STRING);
               
                  $this->name = filter_var($_POST['minus_name'],FILTER_SANITIZE_STRING);
                     
                  // run method
                  $this->update_basket_take_one();

            }
            else if(isset($_POST["delete_id"])) // remove all from basket call
            {
                  // set id so we can search for a match
                  $this->id = filter_var($_POST['delete_id'],FILTER_SANITIZE_STRING);
               
                  $this->name = filter_var($_POST['delete_name'],FILTER_SANITIZE_STRING);
                     
                  // run method
                  $this->update_basket_take_all();
            }


      }
    
//////////////////////// NAVBAR METHODS  /////////////////////////////  

      public static function define_cookie()
      {

         // give basket cookie a name that is a token, 
         define('BASKET_COOKIE','dfdG538Dvcs87MNmg');
         define('ORDER_COOKIE','TdGF356DO0c3s3rd24');
         
         // configure a month for when we want to expire the cookie
         $a_month = time() + (86400 * 30);
         define('ONE_MONTH',$a_month);

      }


      public function sanitize_basket_id_cookie()
      {
         $this->basket_id = filter_var($_COOKIE[BASKET_COOKIE],FILTER_SANITIZE_STRING);
      }


      public function sanitize_order_id_cookie()
      {
         $this->order_id = filter_var($_COOKIE[BASKET_COOKIE],FILTER_SANITIZE_STRING);
      } 


      public static function set_success_flash_message($message)
      {
         self::$success_flash = filter_var($message, FILTER_SANITIZE_STRING);
         
         $_SESSION['success_flash'] = self::$success_flash;
         
      }

      public static function set_error_flash_message($message)
      {

         self::$error_flash = filter_var($message, FILTER_SANITIZE_STRING);

         $_SESSION['error_flash'] = self::$error_flash;

      }

      public static function show_success_flash()
      {

         if(isset($_SESSION['success_flash']))
         {
            echo "<div id='invis_banner' class='login_banner bg-success'> <p class='text-light text-center'>".$_SESSION['success_flash']." </p> </div> "; 

            unset($_SESSION['success_flash']);
            
         }
      
      }


      public static function show_error_flash()
      {

         if(isset($_SESSION['error_flash']))
         {
         
            echo "<div id='invis_banner' class='login_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_flash']." </p> </div> "; 
         
            unset($_SESSION['error_flash']);    
         }        
            
      }


      public function basket_count_nav()
      {
            
         $cookie_name = 'BASKET_COOKIE' ;

         $item_counter = 0;

         if(isset($_COOKIE[$cookie_name]))
         {
            
               $this->basket_id = $_COOKIE[$cookie_name];     
      
               // find the shopping cart in database
               $this->db->query("SELECT * FROM basket WHERE id =  :basket_id " ); 
               
               $this->db->bind(":basket_id", $this->basket_id);
               
               $results = $this->db->single();
                  
               //  fetch the basket from database and turn it back into an array 
               $old_basket_items = json_decode($results->items,true);
               
                  
               // start loop  so we can see if we need to add a new item to the basket or just add to quantity
               foreach($old_basket_items as $basket_item)
               {
                  $item_counter += $basket_item['quantity']; 
               
               }  
               
               return "<span id='basket_counter'>$item_counter </span>" ;
            
         }
         else
         {
               return false;
         }
      
      }


      public function basket_price_nav()
      {
            $cookie_name = 'BASKET_COOKIE' ;

            $total_price = 0;

            if(isset($_COOKIE[$cookie_name]))
            {
            
               $this->basket_id = $_COOKIE[$cookie_name];     
      
               // find the shopping cart in database
               $this->db->query("SELECT * FROM basket WHERE id =  :basket_id " ); 
               
               $this->db->bind(":basket_id", $this->basket_id);
               
               $results = $this->db->single();
                  
               //  fetch the basket from database and turn it back into an array 
               $old_basket_items = json_decode($results->items,true);
               
                  
               // start loop  so we can see if we need to add a new item to the basket or just add to quantity
               foreach($old_basket_items as $basket_item)
               {
                  $total_price += ($basket_item['price'] * $basket_item['quantity']); 
               
               }  
         
               $basket_discount = $total_price * 0.05;

               $final_price = $total_price - $basket_discount;

               return number_format($final_price,2) ;
            
            }
            else
            {
               return false;
            }
      
      }
         

//////////////////////////// BASKET CRUD METHODS ////////////////////////////////

      public function insert_new_basket()
      {

         // grab the item that was posted and turn array to string so we can add to db
         $basket_first_item = json_encode($this->basket_items_array);
         
         // set cookie expire date
         $basket_expire = date("Y-m-d H:i:s",strtotime("+30 days")); 
         
         // run insert query
         $this->db->query("INSERT INTO basket (items,expire_date)  VALUES(:basket_first_item, :basket_expire ) ");
         
         $this->db->bind(":basket_first_item",$basket_first_item);
         $this->db->bind(":basket_expire",$basket_expire);

         $this->db->execute();
         
         // get last inserted id so we can set with it
         $this->basket_id = $this->db->lastInsertId();

         // set cookie value to the id we just inserted into the db
         setcookie(BASKET_COOKIE,$this->basket_id,ONE_MONTH);
         
         // sanitize the cookie
         $this->sanitize_basket_id_cookie();

         // set alert to let user know product was added to basket
         self::set_success_flash_message("x 1 ".$this->name." was added to your basket.");
               
      }

      
      public function delete_basket()
      {
         
         $cookie_name = 'BASKET_COOKIE' ;

         $basket_id = $_COOKIE[$cookie_name];

         $this->db->query('DELETE FROM basket WHERE id = :id ');

         $this->db->bind(':id',$basket_id);

         if($this->db->execute())
         {
            
            setcookie($cookie_name," ", 1);

            return true;
            
         }
         else
         {
            die("delete basket failed");
         }

      }
  

      public function fetch_basket()
      {
         $this->basket_id = $_COOKIE[BASKET_COOKIE];     

         // find the shopping cart in database
         $this->db->query("SELECT * FROM basket WHERE id =  :basket_id " ); 
         $this->db->bind(":basket_id", $this->basket_id);
      
         return $this->db->single();
         
      }

   
        // check to see if we need to update basket (add one to quantity) or create a new basket
      private function does_basket_exist()
      {
         if(isset($_COOKIE[BASKET_COOKIE]))
         {
            $this->update_basket_add_one();
         }
         else
         {
            $this->insert_new_basket();
         }
      }

      ///////// order page methods  (but still C R U D) /////////////////////////////     

      public function show_basket()
      {
         $count = 1;
         $total_price = 0;
         $total_quantity = 0;

         $results = $this->fetch_basket();

            //  fetch the basket from database and turn it back into an array 
         $old_basket_items = json_decode($results->items,true);
         
         foreach($old_basket_items as $basket_item)
         {
            $total = $basket_item['quantity'] * $basket_item['price'];
            $id = $basket_item['id'];
            $name = $basket_item['name'];
            $quantity = $basket_item['quantity'];
            $price = $basket_item['price'];
               echo
                  "<tr>
                        <td> $count </td>
                        <td> $name </td>
                        <td> £$price </td>
                        <td> <span rel='$id' data='$price' value='$name' class='minus_1'> - </span> $quantity  <span rel='$id' data='$price' value='$name' class='plus_1 add_to_basket_btn'> + </span>   </td>
                        <td> <button rel='$id' data='$price' value='$name' class='remove_all btn btn-sm btn-danger'>  Remove </button> </td>
                        <td> £". number_format($total,2) . "</td>               
                  <tr>" ;
                  
                  $total_price += $total;
                  
                  $total_quantity += $basket_item['quantity'];
                  
                  $count++;
            
         }

         $this->basket_total_count = $total_quantity;
         $this->basket_total_price = number_format($total_price,2);
         $this->basket_discount = ($this->basket_total_price /10) /2 ;
         $this->basket_total_price_minus_discount = $this->basket_total_price - $this->basket_discount;
      
      }
 
      public function get_basket_total_count()
      {
         echo $this->basket_total_count;
      }
 
      public function get_basket_total_price()
      {
         echo "£".$this->basket_total_price;
      }
      
      public function get_basket_discount()
      {
         echo "£". number_format($this->basket_discount,2);
      }

      public function get_basket_total_price_minus_discount()
      {
         echo "£".number_format($this->basket_total_price_minus_discount,2);
      }
 
  
////////////////////////// UPDATE BASKET ITEM QUANTITY METHODS  //////////////////////////////////
        
      public function update_basket_add_one()
      {
      
         $results = $this->fetch_basket();  
   
         //  fetch the basket from database and turn it back into an array 
         $old_basket_items = json_decode($results->items,true);
         
            // start loop  so we can see if we need to add a new item to the basket or just add to quantity
            foreach($old_basket_items as $basket_item)
            { 
               // if id is a match to any item from our basket in the db then we will add to the quantity instead of adding a new item
               if($this->basket_items_array[0]['id'] == $basket_item['id'])
               {
                  // add to quantity still a single array as it is not inside the new one yet which is why is easier to add to 
                  $basket_item['quantity'] = $basket_item['quantity'] + $this->basket_items_array[0]['quantity']; //  old as (single) /new (double) but 1 item
                  
                  // set item match to true as id and size was matched for item already in basket
                  $this->item_match = 1;
               }   
                  // put updated item into new array
                  $this->new_basket_items[] = $basket_item;
            }  
            
            
               // IF a match was not found add new item to the basket instead 
            if($this->item_match == 0)
            {
                  // join the the arrays(posted item, and basket) .. add new item to our basket
                  $this->new_basket_items = array_merge($this->basket_items_array,$old_basket_items); 
            }
         
            $this->convert_and_update_query();
   
            // set alert to let user know product was added to basket
            self::set_success_flash_message("x 1 ". $this->name." was added to your basket.");
      }
 


      public function convert_and_update_query()
      { 
         // convert to string so we can add to database
         $this->json_basket_with_new_item = json_encode($this->new_basket_items);
      
         
         // run update query
         $this->db->query("UPDATE basket SET items = :items, expire_date = :expire_date WHERE id = :id ");

         $basket_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
         
         $this->db->bind(":items",$this->json_basket_with_new_item);
         $this->db->bind(":expire_date",$basket_expire);
         $this->db->bind(":id",$this->basket_id);

         $this->db->execute();
         
         // clear old cookie 
         setcookie(BASKET_COOKIE,'',1);

         // set new cookie to a month again
         setcookie(BASKET_COOKIE,$this->basket_id,ONE_MONTH);
      }



      public function update_basket_take_one()
      {
         
         $results = $this->fetch_basket();  

         //  fetch the basket from database and turn it back into an array 
         $old_basket_items = json_decode($results->items,true);
      
         // start loop through re-converted basket array
         foreach($old_basket_items as $basket_item)
         {
               // find the item we clicked by the id 
               if($this->id == $basket_item['id'])
               {
                  // take 1 from quantity
                  $basket_item['quantity'] = $basket_item['quantity'] - 1; // 
                  
               }   

               if($basket_item['quantity'] != 0 )
               {
                  // put updated item into our new array (leave it out if the quantity is 0)
                  $this->new_basket_items[] = $basket_item;
               }
            
         }  
         
         // convert to string so we can add to database
         $this->json_basket_with_new_item = json_encode($this->new_basket_items);
         
         // run update query
         $this->convert_and_update_query();
            
         // set alert to let user know product was added to basket
         self::set_error_flash_message("x 1 ". $this->name." was removed from your basket.");                    

      }
        
            
      public function update_basket_take_all()
      {
         
         $results = $this->fetch_basket();  
      
            //  fetch the basket from database and turn it back into an array 
            $old_basket_items = json_decode($results->items,true);
            
            // start loop through re-converted basket array
            foreach($old_basket_items as $basket_item)
            {
                     // find the item we clicked by the id 
                     if($this->id == $basket_item['id'])
                     {
                        // take all from quantity
                        $basket_item['quantity'] = 0; 
                        
                     }   
      
                     if($basket_item['quantity'] != 0 )
                     {
                        // put updated item into new array (leave it out if the quantity is 0)
                        $this->new_basket_items[] = $basket_item;
                     }
                     
            }  
               
            // convert to string so we can add to database
             $this->json_basket_with_new_item = json_encode($this->new_basket_items);
                    
            // run update query
            $this->convert_and_update_query();
                  
            // set alert to let user know product was added to basket
            self::set_error_flash_message("All of the ". $this->name." was removed from your basket.");
      }
        
   
///////////////////////// STRIPE METHODS  /////////////////////////////  

      public function get_stripe_price()
      {
         $price = $this->basket_price_nav();
         
         return 100 * $price ;

      }


      public function get_stripe_description()
      {
         // get count but it still has html span tags 
         $count_with_span = $this->basket_count_nav();

         // take out the html span tags so we are left with the count only
         $clean_count = preg_replace("/[^0-9]/","",$count_with_span);

         // return a nice description of the order to the customer and form our db
         return "Matteo's Italian (".strval($clean_count)." items)";
      
      }


}




  





 



