<?php
$msg = [
    "email" => "",
    "password" => ""
];

if(isset($_POST['submit']))
{ 
    $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
    $password = filter_var(trim($_POST['password']),FILTER_SANITIZE_STRING);
    
    // validate input
    if(!$this->does_email_exist($email))
    {
        $msg['email'] = "That email address is not in the system";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $msg['email'] = "Please enter a valid email";
    }
    if(empty($email) || $email == "")
    {
        $msg['email'] = "Email can not be left empty";
    }

    if(empty($password) || $password === "")
    {
        $msg['password'] = "Password can not be left empty";
    }

    else
    {
                if(empty($msg['email']) && empty($msg['password']))
                {

                        // if item is added successfuuly them lets redirect the user to the page where they can view the item 
                        if($this->log_in($email,$password))
                        {
                           
                            self::set_success_flash_message("Logged in successfully");
                            header("location: admin/index.php");
                        }
                        else
                        {
                            $msg['password'] = "Wrong Password please try again or click the link to reset";
                        }
                } 
                    
                
            

    }
 
}
