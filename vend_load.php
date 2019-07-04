<?php

// set up for error log
ini_set("log_errors",1);
ini_set("error_log", dirname(__FILE__).'/error_log.txt');

// call the autoloader
 require dirname(__FILE__).'/vendor/autoload.php';

 use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
 
// Create the logger
$logger = new Logger('order_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler(__DIR__.'/data_log.txt', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

// set up hide environment 
$dotenv = Dotenv\Dotenv::create(__DIR__.'/');
$dotenv->load();

// You can now use your logger
// $logger->info('My logger is now ready');

?>