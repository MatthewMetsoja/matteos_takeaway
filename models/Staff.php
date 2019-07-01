<?php

class Staff{

    private $db;

    private $edit_id;

    private $old_first_name;
    private $old_last_name;
    private $old_email;
    private $old_mobile_number;
    private $old_password;
    private $old_picture;
    private $old_role;
    private $old_join_date;
    private $old_last_log_in;

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
            $this->edit_id = filter_var($_GET['edit_member'],FILTER_SANITIZE_STRING);

            // get the data that may need update
            $this->db->query("SELECT * FROM staff WHERE id = :edit_id" );
            $this->db->bind(':edit_id',$this->edit_id);
            $this->db->execute();
            
            $result = $this->db->single();

            $this->old_first_name = $result->first_name;
            $this->old_last_name = $result->last_name;
            $this->old_email = $result->email;
            $this->old_mobile_number = $result->mobile_number;
            $this->old_password = $result->password;
            $this->old_picture = $result->picture;
            $this->old_role = $result->role;
            $this->old_join_date = $result->join_date;
            $this->old_last_log_in = $result->last_log_in;
        
            // show edit menu form
            require_once "includes/staff_form_sanitizer.php";
            require_once "includes/staff_edit_member.php";
        }

          //view all staff table
          elseif(!isset($_GET['edit_member']) && !isset($_GET['add_member']))
          {
              require_once "includes/delete_modal.php";
  
              $this->showAllStaff();
  
              if(isset($_POST['submit_delete']) && self::$delete_error_message == "")
              {
                $this->delete_staff_member();  
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


        

 


/////////// C R U D (ADMIN) methods /////////

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


            public function getStaff()
            {
                
                $this->db->query('SELECT * FROM staff');
                                        
                $results = $this->db->resultset();
        
                return $results;
            
            }
        
            public function showAllStaff()
            {
               
                        
                $results = $this->getStaff();
        
                 
                
                echo "
                    <table width='100'class='table table-hover table-bordered mr-4 ml-2'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Picture</th>
                                <th>Join date</th>
                                <th>Last Logged in</th>
                                <th>Edit</th>
                                <th>Delete</th>
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
                             <td> <img class='profile_pic' src='$row->picture'> </td> 
                             <td> $row->join_date</td>
                             <td> $row->last_log_in</td>
                             <td> <a class='btn btn-sm btn-dark' href='staff.php?edit_member=$row->id'>Edit</a> </td> 
                             <td> <button value='$row->id' rel='$row->first_name $row->last_name' type='button' javascript='void(0)' class='delete_item_from_menu_btn btn btn-danger btn-sm'>Delete </button> </td> 
                             <tr>";
                        }
                    
                  
                  echo "</tbody>
                
                      </table>";
        
            }

            public function does_email_exist($email)
            {
                $this->db->query("SELECT * FROM staff WHERE email = :email");
                $this->db->bind(":email",$email);
                $this->db->resultset();
                
                if($this->db->rowCount() != 0)
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
                $this->db->query("UPDATE staff SET first_name = :first_name, last_name = :last_name,
                 email = :email, password = :password, mobile_number = :mobile_number, role = :role,
                 picture = :picture, join_date = :join_date, last_log_in = :last_log_in
                 WHERE id = :edit_id");
                
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
                        self::set_error_flash_message("Staff member deleted successfully!"); 
                        header("location: staff.php");  
                    }  
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