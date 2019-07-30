<?php

class Staff
{

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

    private $reset_token;

    public static $delete_error_message = "";
    public static $id_to_delete = "";

    public static $error_flash;
    public static $success_flash;
       

////////////////////  CONSTRUCTOR ////////////////
    
    public function __construct()
    {
        $this->db = new Database;

        if(isset($_GET['add_member']))
        {
            // show edit menu form
            require_once "includes/staff_form_sanitizer.php";
            require_once "includes/staff_add_new_member.php";    
        }
        else if(isset($_GET['edit_member']))
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
        elseif(!isset($_GET['edit_member']) && !isset($_GET['add_member']) && basename($_SERVER['PHP_SELF']) == "staff.php") //view all staff table
        {
              require_once "includes/delete_modal.php";
  
              $this->showAllStaff();
  
              if(isset($_POST['submit_delete']) && self::$delete_error_message == "")
              {
                $this->delete_staff_member();  
              } 
  
        }
        elseif(basename($_SERVER['PHP_SELF']) == "login.php")
        {
            require_once "includes/login_form_sanitizer.php";
            require_once "includes/login_form.php";
        }
        elseif(basename($_SERVER['PHP_SELF']) == "forgot.php")
        {  
            require_once "includes/forgot_form_sanitizer.php";
            require_once "includes/forgot_form.php";
        }
        elseif(basename($_SERVER['PHP_SELF']) == "reset.php")
        {
            if(!isset($_GET['reset_token']))
            {
                header("Location: login.php");
            }
            else
            {
                $this->reset_token = filter_var($_GET['reset_token'],FILTER_SANITIZE_STRING);

                require_once "includes/reset_form_sanitizer.php";
                require_once "includes/reset_form.php";
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
        {
            echo "<div id='invis_banner' class='login_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_flash']." </p> </div> "; 
        
            unset($_SESSION['error_flash']);            
        }
    }
 


/////////// C R U D (ADMIN) methods /////////

    // Create
        public function add_new_staff_member($data)
        {
            $this->db->query("INSERT INTO staff(first_name, last_name, email, password, mobile_number, role, picture, join_date, last_log_in, reset_token)
            VALUES(:first_name, :last_name, :email, :password, :mobile_number, :role, :picture, :join_date, :last_log_in, :reset_token )");

            $this->db->bind(':first_name',$data['first_name']);
            $this->db->bind(':last_name',$data['last_name']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':password',$data['password']);
            $this->db->bind(':mobile_number',$data['mobile_number']);
            $this->db->bind(':role',$data['role']);
            $this->db->bind(':picture',$data['picture']);
            $this->db->bind(':join_date',$data['join_date']);
            $this->db->bind(':last_log_in',$data['last_log_in']);
            $this->db->bind(':reset_token',$data['reset_token']);

            if($this->db->execute())
            {
                return true; 
            }
            else
            {
                return false;
            }
        
        }

    // Read
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
    
                        foreach($results as $row)
                        {
                    
                            if($row->join_date == $row->last_log_in)
                            {
                                    $last_log_in = 'Never';
                            }
                            else
                            {
                                    $last_log_in = date('M-d-Y H:i:a',strtotime($row->last_log_in));           
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
                                <td> $last_log_in</td>
                                <td> <a class='btn btn-sm btn-dark' href='staff.php?edit_member=$row->id'>Edit</a> </td> 
                                <td> <button value='$row->id' rel='$row->first_name $row->last_name' type='button' javascript='void(0)' class='delete_item_from_menu_btn btn btn-danger btn-sm'>Delete </button> </td> 
                            <tr>";
                        }
                 
                echo "
                    </tbody>
            
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

// Update
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

// Delete
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

/// LOGIN ////
        public function log_in($email,$password)
        {
            $this->db->query("SELECT * FROM staff WHERE email = :email");
            $this->db->bind(":email",$email);
            $this->db->execute();
           
            $result = $this->db->single();
           
            if(password_verify($password,$result->password))
            {
                $_SESSION['id'] = $result->id;
                $_SESSION['email'] = $result->email;
                $_SESSION['role'] = $result->role;
                $_SESSION['first_name'] = $result->first_name;
                $_SESSION['last_name'] = $result->last_name;
                
                $last_log_in = date('Y-m-d H:i:s');
                $this->db->query("UPDATE staff SET last_log_in = :last_log_in WHERE email = :email");
                $this->db->bind(":last_log_in",$last_log_in);
                $this->db->bind(":email",$email);
                $this->db->execute();
                
                return true;
            }
            else
            {
                return false;
            }

        }

        public static function log_out()
        {
            session_unset();

            session_destroy();

            header("location: index.php");
            
        }

/// forgot password page methods
        public function set_reset_token()
        {  
            $length = 50;
           
            // create some random number for password reset
            $this->reset_token = bin2hex(openssl_random_pseudo_bytes($length));

        }   

        public function update_token($email)
        {
            $this->db->query("UPDATE staff SET reset_token = :reset_token WHERE email = :email ");
            $this->db->bind(":reset_token",$this->reset_token);
            $this->db->bind(":email",$email);
            
            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
/// reset password page methods
        public function reset_password($new_password)
        {
            $this->db->query("SELECT * FROM staff WHERE reset_token = :reset_token");
            $this->db->bind(":reset_token",$this->reset_token);
            $result = $this->db->single();        

            $this->reset_token = "";

            $new_password = password_hash($new_password,PASSWORD_DEFAULT); 
         
            $this->db->query("UPDATE staff SET password = :password, reset_token = :reset_token WHERE email = :email");
            $this->db->bind(":password",$new_password);
            $this->db->bind(":reset_token",$this->reset_token);
            $this->db->bind(":email",$result->email);

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