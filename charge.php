<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Basket.php";
require_once "models/Transaction.php";
require_once "models/My_customers.php";


$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$order = new Basket;

$results = $order->fetch_basket();
$items_ordered_as_string = $results->items ;

$amount = $order->basket_price_nav();


$pusher_options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );

  $pusher = new Pusher\Pusher(
     getenv(PUSHER_KEY),
     getenv(PUSHER_SECRET),
     getenv(PUSHER_APP_ID),
    $pusher_options
  );


\Stripe\Stripe::setApiKey(getenv(STRIPE_SK_TEST));

// sanitize post array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

// set each sanitized item to var
$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$delivery_address = $POST['delivery_address'];
$postcode = $POST['postcode'];
$phone_number = $POST['phone_number'];
$email = $POST['email'];
$token = $POST['stripeToken'];

// Create a customer in Stripe
$customer = \Stripe\Customer::create(array(
    "email" => $email,
    "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
    "amount" => $order->get_stripe_price(),
    "currency" => "gbp",
    "description" => $order->get_stripe_description() ,
    "customer" => $customer->id
));

//Customer Data
$customerData = array(
    'id' => $charge->customer,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'delivery_address' => $delivery_address,
    'postcode' => $postcode,
    'phone_number' => $phone_number
);

/// Instantiate Customer
$my_customer = new My_customers();

// Add Customer to DB
$my_customer->addCustomer($customerData);


//transaction Data
$transactionData = array(
    'id' => $charge->id,
    'customer_id' => $charge->customer,
    'items_ordered' => $items_ordered_as_string,
    'amount' => $order->basket_price_nav(),
    'status' => $charge->status,
);

// get back items as array for the email confirmation.
$items_as_array = json_decode($items_ordered_as_string,true);

// Instantiate transaction
$transaction = new Transaction();

// Add Transaction to DB
$transaction->addTransaction($transactionData);



// send confirmation email 
// CONFIGURE PHP MAILER... Confirmation Email
$mail = new PHPMailer();    // Passing `true` enables exceptions
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
    $mail->setFrom('matteo\'s@takeaway.com','Matteo\'s');  // Name is optional
    $mail->addAddress($email); // Add a recipient
   
   //Images to embed
    $mail->addEmbeddedImage('/Applications/MAMP/htdocs/portfolio/projects/matteos_takeaway/images/main_logo.png','logo');   
    
    $the_message = 
    ' <h1 style="color:red; text-align:center;"> Matteo\'s Take-away </h1> 
    
    <h2 style="color:green; text-decoration:underline; text-align:center;"> Thanks you </h2>'. 

    '<h3 style="text-align:center;"> Items Purchased </h3>'. 
            '<table style="text-align:center">
                <thead class="thead-inverse">
                    <tr>
                        <th width="25px">#</th>
                        <th width="130px">Item</th>
                        <th width="50px">Price</th>
                        <th width="50px">Quantity</th>
                        <th width="50px">Total</th>
                    </tr>
                </thead>
                <tbody>'.
                    '<span style="display:none">'. $i = 1;' .</span>'.
                    
                    $total_quantity_count = 0;
                    $grand_total = 0;
                    
                    foreach($items_as_array as $item)
                    {
                        
                        $the_message.=
                        '<tr>'.
                            '<td> <b>'. $i .'.</b> </td>'.
                            '<td>'.$item['name']. '</td>'.
                            '<td>£'. $item['price'].  '</td>'.
                            '<td>'. $item['quantity']. '</td>'.
                            '<td> £'.$total = number_format($item['price'] * $item['quantity'],2);'</td>'.
                    
                            $i++;
            
                            $total_quantity_count = $total_quantity_count + $item['quantity'];
                            
                            $the_message.=
                        '</tr>' ; 
                    }  
                    
                    $date   = new DateTime();  

                    $the_message.=  
                    '
                
                </tbody>
            </table> <br><br>
            
            <div> 
                <div> <b> Date of Order: </b> '.  $date->format("F j, Y g:i:a"). ' </div> 
                <div> <b> Total items purchased: </b>'. $total_quantity_count. '</div>'.  
                '<div> <b>  Order total:</b> £'. $amount. '</div> <br>  
            </div>'; 
            
            $the_message.=
                '<h3 style="text-decoration:underline; margin-bottom:-2px"> Delivery Details </h3>
                    <div> 
                        <div> <span>'. $first_name." ".$last_name. '</span> </div>  
                        <div> <span>'. $delivery_address.'<br>'.
                            $postcode .' </span><br>'. 
                        '</div>'.  
                        '<div>  <span>'.  $email.'</span>  </div>'.  
                        '<div> <span>'. $phone_number.' </span> </div> <br>'.  
                        '<div> <b> Order reference number: </b> '. $charge->id.  '</div>'. 
                    '</div>';


    //         //Content
  
   
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Order confirmation';
            $mail->Body    = 
            '<h1 style="text-align:center;"> <img width="60px" height="60px" src="cid:logo"> </h1> '.
            $the_message;
        

            $mail->send();
    
} 
catch (Exception $e)
{
    $msg = 'Message could not be sent. Mailer Error:'.$mail->ErrorInfo;
    $msg_class = "text text-danger";
}


// redirect to success page
header("Location: success.php?tid=".$charge->id."&product=".$charge->description);

