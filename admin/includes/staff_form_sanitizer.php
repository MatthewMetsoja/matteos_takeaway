<?php
$msg = [
    "first_name" => "",
    "last_name" => "",
    "email" => "",
    "mobile_number" => "",
    "password" => "",
    "password_confirm" => "",
    "picture" => "",
    "role" =>  "" 
];

if(isset($_POST['submit']))
{ 
    $first_name = filter_var(trim($_POST['first_name']),FILTER_SANITIZE_STRING);
    $last_name = filter_var(trim($_POST['last_name']),FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $mobile_number = filter_var(trim($_POST['mobile_number']),FILTER_SANITIZE_STRING); 
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $picture = $_FILES['picture']['name'];
    $tmp_picture = $_FILES['picture']['tmp_name'];
    $role = filter_var($_POST['role'],FILTER_SANITIZE_STRING);
    

    // validate input
    if(empty($first_name) || $first_name === "")
    {
        $msg['first_name'] = "First Name can not be left empty";
    }
    
    if(empty($last_name) || $last_name === "")
    {
        $msg['last_name'] = "Last Name can not be left empty";
    }

    if(empty($email) || $email == "")
    {
        $msg['email'] = "Email can not be left empty";
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $msg['email'] = "Please enter a valid email";
    }

    
    if(strlen($mobile_number) != 11)
    {
        $msg['mobile_number'] = "Mobile number must be 11 digits long";
    }

    if(strpos($mobile_number,"0") !== 0)
    {
     $msg['mobile_number'] ="Mobile number must start with 0";   
    }

    if(empty($mobile_number) || $mobile_number === "")
    {
        $msg['mobile_number'] = "Mobile number can not be left empty";
    }


    if(empty($role))
    {
     $msg['role'] = "Please choose the new staff member's site access";
    }

    if(empty($password) || $password === "")
    {
        $msg['password'] = "Password can not be left empty";
    }

    if(empty($password_confirm) || $password_confirm === "")
    {
        $msg['password_confirm'] = "Password can not be left empty";
    }

    if(strlen($password) < 5)
    {
        $msg['password'] = "Password must be at least 5 characters long";
        $msg['password_confirm'] = "Password must be at least 5 characters long";
    }

    if($password !== $password_confirm)
    {
        $msg['password'] = "Passwords do not match";
        $msg['password_confirm'] = "Passwords do not match";
    }
   
    else
    {
        
        if(isset($_GET['add_member']))
        {
            if(empty($picture))
            {
                $msg['picture'] = "Please upload a picture of the new staff member";
            }

            if($this->does_email_exist($email))
            {
                $msg['email'] = "That email is taken already.. please choose another";
            }

            if(empty($msg['first_name']) && empty($msg['last_name']) && empty($msg['email']) && 
            empty($msg['mobile_number']) && empty($msg['password']) && empty($msg['password_confirm']) &&
            empty($msg['picture']) && empty($msg['role']) )
            {
                $password = password_hash($password,PASSWORD_DEFAULT);

                move_uploaded_file($tmp_picture,"images/staff/$picture");
                $picture = "images/staff/$picture";
        
                $join_date = date('Y-m-d H:i:s');
                $last_log_in = date('Y-m-d H:i:s');
                
                $data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $password,
                    'mobile_number' => $mobile_number,
                    'role' => $role,
                    'picture' => $picture,
                    'join_date' => $join_date,
                    'last_log_in' => $last_log_in,
                    'reset_token' => ''
                ];

                // if item is added successfuuly them lets redirect the user to the page where they can view the item 
                if($this->add_new_staff_member($data))
                {
                    self::set_success_flash_message("New staff member added successfully");
                    header("location: staff.php");
                }
            } 
            
        }
        elseif(isset($_GET['edit_member']))
        {
                // set pictute to the old one if it is not being updated
                if(empty($picture))
                {
                    $picture = $this->old_picture;
                }
                else
                {
                    move_uploaded_file($tmp_picture,"images/staff/$picture");
                    $picture = "images/staff/$picture";   
                }  
            
                if(empty($msg['first_name']) && empty($msg['last_name']) && empty($msg['email']) && 
                empty($msg['mobile_number']) && empty($msg['password']) && empty($msg['password_confirm']) &&
                empty($msg['picture']) && empty($msg['role']) )
                {
                        
                        // only hash password if it is being updated so that it does not get hashed twice(locking user out of there account)
                        if($password !== $this->old_password)
                        {
                            $password = password_hash($password,PASSWORD_DEFAULT);
                        }else
                        {
                            $password = $this->old_password;   
                        }
                            
                    

                        $data = 
                        [
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'password' => $password,
                            'mobile_number' => $mobile_number,
                            'role' => $role,
                            'picture' => $picture,
                            'join_date' => $this->old_join_date,
                            'last_log_in' => $this->old_last_log_in
                        ];


                        // if update was successfull redirect
                            if($this->update_staff_member($data))
                            {
                                self::set_success_flash_message("Staff member updated successfully");
                                header("location: staff.php");
                            }
                    
                }
        }

    }
 
}
