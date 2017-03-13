<?php 

use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;


$gateway = new Gateway("websocket://127.0.0.1:8282");

$gateway->name = 'YourAppGateway';

$gateway->count = 4;

$gateway->lanIp = '127.0.0.1';

$gateway->startPort = 2900;

$gateway->registerAddress = '127.0.0.1:1238';

if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

