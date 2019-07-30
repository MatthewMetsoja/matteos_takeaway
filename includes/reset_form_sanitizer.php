<?php

$msg = [
    "password" => "",
    "success" => ""
];


if(isset($_POST['submit']))
{ 
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $password_confirm = filter_var($_POST['password_confirm'],FILTER_SANITIZE_STRING);
    
    if($password !== $password_confirm ) 
    {
        $msg['password'] = "Passwords do not match";
    }

    if( strlen($password) < 6 ) 
    {
        $msg['password'] = "Password must be at least 5 characters long";
    }
    
    if(empty($password) || empty($password_confirm))
    {
        $msg['password'] = "Password can not be left empty";
    }

    else
    {

        if(empty($msg['password']))
        {
            
            if($this->reset_password($password))
            {
                $msg['success'] = 'Password update successfull. Please click <a href="login.php"> here </a> to log in ';
            }
            else
            {
                $msg['password'] = 'Reset Password function failed. Please Try again.  '; 
            }


        }
    }

}


