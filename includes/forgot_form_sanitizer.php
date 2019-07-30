<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = [
    "email" => "",
    "password" => ""
];

if(isset($_POST['forgot_submit']))
{ 
    $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
    
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

    else
    {
        if(empty($msg['email']) )
        {

            $this->set_reset_token(); 
            
            // CONFIGURE PHP MAILER
            $mail = new PHPMailer(true);    // Passing `true` enables exceptions
            
            try
            {
                //Server settings
            
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.mailtrap.io' ;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = getenv(MAILTRAP_USER);                 // SMTP username
                $mail->Password = getenv(MAILTRAP_PASS);                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 2525 ;                                    // TCP port to connect to

                $mail->CharSet = 'UTF-8' ; 

                //Recipients
                $mail->setFrom('matteos_takeaway@icloud.com','Matteos Italian Takeaway');  // Sender
                $mail->addAddress($email); // recipient
            

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password reset';
                $mail->Body    = '<p> Please click the link to reset your password 
                <a href="http://localhost:8888/matteos_takeaway/reset.php?reset_token='.$this->reset_token. ' " >  CLICK HERE TO RESET PASSWORD </a>
                </p> ';
            

                $mail->send();
            
                $msg['password'] = ' Thank you! Please check your email for password reset link';

                if(!$this->update_token($email))
                {
                    $msg['email'] = ' Unable to insert reset token, please try again if error persists then contact admin';
                }
            }
            catch (Exception $e) 
            {
                $msg = 'Message could not be sent. Mailer Error:'.$mail->ErrorInfo;
                $msg_class = "text text-danger";
            }

        } 
                    
                
            

    }
 
}



