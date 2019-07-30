<?php


class Menu
{

    private $db;

    private $category_id_from_get;

    private $edit_id;

    private $count;

    private $old_name;
    private $old_category_id;
    private $old_category_name;
    private $old_description;
    private $old_price;
    private $old_vegatarian;
    private $old_nut_traces;

    public static $delete_error_message = "";
    public static $id_to_delete = "";

    public static $error_flash;
    public static $success_flash;
       

/////////////////  CONSTRUCTOR ///////////////////

    public function __construct()
    {
        $this->db = new Database;

        //view items tables
        if(isset($_GET['category']))
        {
            
            // sanitize get
            $this->category_id_from_get = filter_var($_GET['category'],FILTER_SANITIZE_STRING);
            
            require_once "includes/delete_modal.php";

            // show menu items from selected category
            $this->showMenuItems_Admin();

            if(isset($_POST['submit_delete']) && self::$delete_error_message == "")
            {
              $this->delete_item();  
            } 

        }

        else if(isset($_GET['add_item']))
        {
            filter_var($_GET['add_item'],FILTER_SANITIZE_STRING);

            // show edit menu form
            require_once "includes/menu_form_sanitizer.php";
            require_once "includes/menu_add_new_item.php";    

        }

        else if(isset($_GET['edit_item']))
        {
            // sanitize get
            $this->edit_id = filter_var($_GET['edit_item'],FILTER_SANITIZE_STRING);

            // get the item values
            $this->db->query("SELECT categories.title, m.id AS m_id, m.category_id AS m_cid, 
            m.name,m.price,m.description,m.vegetarian,m.nut_traces FROM menu AS m
            LEFT JOIN categories ON m.category_id = categories.id  WHERE m.id = :edit_id" );
           
            $this->db->bind(':edit_id',$this->edit_id);
            
            $this->db->execute();
            
            $result = $this->db->single();

            $this->old_name = $result->name;
            $this->old_category_id = $result->m_cid;
            $this->old_category_name = $result->title;
            $this->old_price = $result->price;
            $this->old_description = $result->description;
            $this->old_vegatarian = $result->vegetarian;
            $this->old_nut_traces = $result->nut_traces;
        
            // show edit menu form
            require_once "includes/menu_form_sanitizer.php";
            require_once "includes/menu_edit_item.php";
        }

    }



/// Nav
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
         
         echo "<div id='invis_banner' class='login_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_flash']." </p> </div> "; 
         
         unset($_SESSION['error_flash']);            
            
      }






///////////// PUBLIC PAGE METHODS ///////////////// 

    public function getMenu($category_id)
    {
        
        $category = $category_id; 

        $this->db->query('SELECT categories.title, m.id AS m_id, m.category_id AS m_cid, 
        m.name,m.price,m.description,m.vegetarian,m.nut_traces FROM menu AS m
        LEFT JOIN categories ON m.category_id = categories.id  WHERE m.category_id = :cat');

        $this->db->bind(":cat", $category);
                                
        $results = $this->db->resultset();

        return $results;
    
    }

    public function getMenuItemCount($category_id)
    {
        
       $this->getMenu($category_id);

       return $this->count = $this->db->rowCount();

    
    }

    public function showMenu($category_id)
    {
        
        $results = $this->getMenu($category_id);

        $count = 0;
        
        $num_rows = $this->getMenuItemCount($category_id);
    
        //check if count is odd or even
        if($num_rows % 2)
        {
            // value is odd so add 1
            $num_rows = $num_rows + 1;
        }

        $half_rows = $num_rows/2;
        
        foreach($results as $result)
        {
                   
            if($result->vegetarian == true)
            {
                $veg = "<span class='text-success'> (V) </span>";
            }
            else
            {
                $veg = "";
            } 

            if($result->nut_traces == true)
            {
                $nuts = "<span class='text-danger'> (N) </span>";
            }
            else
            {
                $nuts = "";
            } 
            
            // show menu with bootstrap break half way
            echo "<span class='menu_head'>".$result->name."  ".$veg. "     " .$nuts.  " </span><br>";
            echo  $result->description. "<br>";
            echo "£".$result->price."  ". " <button type='button' data='$result->price' value='$result->name' rel='$result->m_id' id='' class='add_to_basket_btn btn btn-sm btn-warning'>Add to order </button><br>";
            echo  "<br><br>"; 
           
            $count++;

            if($count == $half_rows)
            {
                echo "</div> <div class='col-6 text-center'>";
            }

        }

    }

/////////// C R U D (ADMIN) methods /////////
    public static function delete_item_verification()
    {
        if(isset($_POST['submit_delete']))
        {
            $password = filter_var($_POST['delete_password'],FILTER_SANITIZE_STRING);
            $password_confirm = filter_var($_POST['delete_password_confirm'],FILTER_SANITIZE_STRING);
            

            isset($_POST['id_to_delete']) ? self::$id_to_delete = filter_var($_POST['id_to_delete'],FILTER_SANITIZE_STRING) : self::$delete_error_message = "Delete failed, Problem fetching ID!"; 
        
            if($password !== getenv(MASTER_PASS) || $password_confirm !== getenv(MASTER_PASS))
            {
                self::$delete_error_message = "Delete failed, Incorrect Master Password!";
            }
            
            if($password !== $password_confirm)
            {
                self::$delete_error_message = "Delete failed, Passwords do not match!";
            }
            
            if(empty($password) || $password == "")
            {
                self::$delete_error_message = "Delete failed, Passwords must not be empty!";
            }

            if(empty($password_confirm) || $password == "")
            {
                self::$delete_error_message = "Delete failed, Passwords must not be empty!";
            }
         
        }
        
    }

    private function delete_item()
    { 
        if(isset(self::$id_to_delete))
        {   
            $this->db->query("DELETE FROM menu WHERE id = :id_to_delete ");
            $this->db->bind(":id_to_delete",self::$id_to_delete);
            
            if($this->db->execute())
            {
                self::set_error_flash_message("Deleted successfully!"); 
                header("location: menu.php?category=$this->category_id_from_get");  
            }  
        }  
    }


    public function showMenuItems_Admin()
    {         
        $results = $this->getMenu($this->category_id_from_get);
   
        echo "
            <table class='table table-hover table-responsive table-inverse mr-4 ml-2'>
                <thead>
                    <tr>
                        <th width='2%'>ID</th>
                        <th width='5%'>Category</th>
                        <th width='10%'>Name</th>
                        <th width='5%'>Price</th>
                        <th width='15'%>Description</th>
                        <th width='4%'>Vegetarian</th>
                        <th width='4%'>Nut traces</th>
                        <th width='4%'>Edit</th>
                        <th width='4%'>Delete</th>
                    </tr>
                </thead>
               
                <tbody>";
                    foreach($results as $row)
                    {
                    
                        if($row->vegetarian == true)
                        {
                                $veg = 'Yes';
                        }else
                        {
                        $veg = 'No';
                        } 

                        if($row->nut_traces == true)
                        {
                        $nuts = 'Yes';
                        }else
                        {
                        $nuts = 'No';
                        } 
                    
                        echo 
                        "<tr>
                            <td> $row->m_id </td> 
                            <td> $row->title</td> 
                            <td> $row->name </td> 
                            <td> £$row->price </td> 
                            <td> $row->description </td> 
                            <td> $veg </td> 
                            <td> $nuts </td> 
                            <td> <a class='btn btn-sm btn-dark' href='menu.php?edit_item=$row->m_id'>Edit</a> </td> 
                            <td> <button value='$row->m_id' rel='$row->name' type='button' javascript='void(0)' class='delete_item_from_menu_btn btn btn-danger btn-sm'>Delete </button> </td> 
                        <tr>";
                    }
            
            echo "
                </tbody>
        
            </table>";
    }


    /// for admin menu forms
    public function show_categories_select()
    {
        $this->db->query("SELECT * FROM categories");

        $results = $this->db->resultset();

       
        if(!isset($_POST['category']) && !isset($this->old_category_id))  // add item form if it has not been submited with errors
        {

                echo "<option  default selected>** Please choose a category **</option>"; 

            foreach($results as $result)
            {
                echo "<option value='$result->id'> $result->title </option>"; 
            }
        }
        else if(!isset($_POST['category']) && isset($this->old_category_id))  ////  update item form 
        {

            foreach($results as $result)
            {
                if($this->old_category_id == $result->id)
                {
                    echo "<option default selected value='$result->id'> $result->title </option>"; 
                }
                else
                {
                    echo "<option value='$result->id'> $result->title </option>"; 
                }

            }    
        }
    
        else   ////  insert item form that has been filled out with errors but select was filled correctly (keep value)
        {
            foreach($results as $result)
            {
                if($_POST['category'] == $result->id)
                {
                    echo "<option default selected value='$result->id'> $result->title </option>"; 
                }
                else
                {
                    echo "<option value='$result->id'> $result->title </option>"; 
                }
        
            }

        }
    }  

    public function add_new_item($data)
    {
        $this->db->query("INSERT INTO menu(category_id, name, price, description, vegetarian, nut_traces)
        VALUES(:cat_id, :name, :price, :description, :vegetarian, :nut_traces)");

        $this->db->bind(':cat_id',$data['category']);
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':price',$data['price']);
        $this->db->bind(':description',$data['description']);
        $this->db->bind(':vegetarian',$data['vegetarian']);
        $this->db->bind(':nut_traces',$data['nut_traces']);

        if($this->db->execute())
        {
            return true; 
        }
        else
        {
            return false;
        }
      
    }

    public function update_item($data)
    {
        $this->db->query("UPDATE menu SET category_id = :cat_id, name = :name, price = :price,
        description = :description, vegetarian = :vegetarian, nut_traces =:nut_traces WHERE id = :edit_id");
    
        $this->db->bind(':cat_id',$data['category']);
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':price',$data['price']);
        $this->db->bind(':description',$data['description']);
        $this->db->bind(':vegetarian',$data['vegetarian']);
        $this->db->bind(':nut_traces',$data['nut_traces']);
        $this->db->bind(':edit_id',$this->edit_id);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }

    }



}