<?php

require_once "vend_load.php";
require_once "config/pdo_db.php";
require_once "models/Basket.php";
require_once "models/Transaction.php";
require_once "models/My_customers.php";
$order = new Basket;

$results = $order->fetch_basket();
$items_ordered_as_string = $results->items ;


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

   

    // // Instantiate Customer
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


// Instantiate transaction
$transaction = new Transaction();

// Add Transaction to DB
$transaction->addTransaction($transactionData);


//  // set up pusher array       
//  $pusher_data['message'] = $delivery_address;    // must be an array or toastr will not work

//  // send pusher to js
//  $pusher->trigger('notifications','new_order',$pusher_data);


// redirect to success page
header("Location: success.php?tid=".$charge->id."&product=".$charge->description);

