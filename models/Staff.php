<?php

class Staff{

    private $db;
    
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $mobile;
    private $role;




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
       
    /////  CONSTRUCTOR ////
    public function __construct()
    {
        $this->db = new Database;

        if(isset($_GET['add_member']))
        {

            // show edit menu form
            require_once "includes/staff_form_sanitizer.php";
            require_once "includes/staff_add_new_member.php";    

        }

        if(isset($_GET['edit_member']))
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

          //view all staff table
          else
          {
              require_once "includes/delete_modal.php";
  
              // show menu items from selected category
            //   $this->showMenuItems_Admin();
              $this->showAllStaff();
  
              if(isset($_POST['submit_delete']) && self::$delete_error_message == "")
              {
                $this->delete_item();  
              } 
  
          }

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
         
         echo "<div id='invis_banner' class='login_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_flash']." </p> </div> "; 
         
         unset($_SESSION['error_flash']);            
            
      }


///// methods for public pages ///////// 

    public function getStaff()
    {
        
        $this->db->query('SELECT * FROM staff');
                                
        $results = $this->db->resultset();

        return $results;
    
    }


/////////// C R U D (ADMIN) methods /////////

    public static function delete_staff_member_verification()
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

    public function delete_staff_member()
    { 
        if(isset(self::$id_to_delete))
        {   
            $this->db->query("DELETE FROM staff WHERE id = :id_to_delete ");
            $this->db->bind(":id_to_delete",self::$id_to_delete);
            
            if($this->db->execute())
            {
                self::set_error_flash_message("Deleted successfully!"); 
                header("location: staff.php");  
            }  
        }  
    }


    public function showMenuItems_Admin()
    {
       
                
        $results = $this->getStaff();

         
        
        echo "
            <table class='table table-hover table-responsive table-inverse mr-4 ml-2'>
                <thead>
                    <tr>
                        <th width='2%'>ID</th>
                        <th width='4%'>First Name</th>
                        <th width='4%'>Last Name</th>
                        <th width='5%'>Email</th>
                        <th width='4'%>Mobile</th>
                        <th width='4%'>Role</th>
                        <th width='4%'>Picture</th>
                        <th width='4%'>Edit</th>
                        <th width='4%'>Delete</th>
                    </tr>
                </thead>
                <tbody>";


                foreach($results as $row){
                   
                    if($row->join_date == $row->last_log_in)
                    {
                            $row->last_log_in = 'Never';
                    } 

                    echo 
                    "<tr>
                     <td> $row->id </td> 
                     <td> $row->first_name</td> 
                     <td> $row->last_name </td> 
                     <td> $row->email </td> 
                     <td> $row->mobile_number </td> 
                     <td> $row->role </td> 
                     <td> $row->picture </td> 
                     <td> $row->join_date</td>
                     <td> $row->last_log_in</td>
                     <td> <a class='btn btn-sm btn-dark' href='menu.php?edit_member=$row->id'>Edit</a> </td> 
                     <td> <button value='$row->id' rel='$row->picture' type='button' javascript='void(0)' class='delete_item_from_menu_btn btn btn-danger btn-sm'>Delete </button> </td> 
                     <tr>";
                }
            
          
          echo "</tbody>
        
              </table>";

    }




            public function add_new_staff_member($data)
            {
                $this->db->query("INSERT INTO staff(first_name, last_name, email, password, mobile_number, role, picture, join_date, last_log_in)
                VALUES(:first_name, :last_name, :email, :password, :mobile_number, :role, :picture, :join_date, :last_log_in )");

                $this->db->bind(':first_name',$data['first_name']);
                $this->db->bind(':last_name',$data['last_name']);
                $this->db->bind(':email',$data['email']);
                $this->db->bind(':password',$data['password']);
                $this->db->bind(':mobile_number',$data['mobile_number']);
                $this->db->bind(':role',$data['role']);
                $this->db->bind(':picture',$data['picture']);
                $this->db->bind(':join_date',$data['join_date']);
                $this->db->bind(':last_log_in',$data['last_log_in']);

                if($this->db->execute())
                {
                return true; 
                }
                else
                {
                    return false;
                }
            
            }

            public function update_staff_member($data)
            {
                $this->db->query("UPDATE menu SET category_id = :cat_id, name = :name, price = :price,
                description = :description, vegetarian = :vegetarian, nut_traces =:nut_traces WHERE id = :edit_id");
                
                $this->db->bind(':first_name',$data['first_name']);
                $this->db->bind(':last_name',$data['last_name']);
                $this->db->bind(':email',$data['email']);
                $this->db->bind(':password',$data['password']);
                $this->db->bind(':mobile_number',$data['mobile_number']);
                $this->db->bind(':role',$data['role']);
                $this->db->bind(':picture',$data['picture']);
                $this->db->bind(':join_date',$data['join_date']);
                $this->db->bind(':last_log_in',$data['last_log_in']);
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













    // public function __construct()
    // {
    //  $this->db = new Database;
     
    // }


    // public static function hash_password()
    // {

    // }
    
    
    // private function email_exists()
    // {

    // }


    // private function create_staff_memember()
    // {


    // }
    
    // private function select_all_staff_memembers()
    // {


    // }


    // private function update_staff_memember()
    // {


    // }

    // private function delete_staff_memember()
    // {


    // }
    
    
    // private function login($data)
    // {
        


    // }






















}