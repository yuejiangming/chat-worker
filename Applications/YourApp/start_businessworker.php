<?php 
use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;


$worker = new BusinessWorker();

$worker->name = 'YourAppBusinessWorker';

$worker->count = 4;

$worker->registerAddress = '127.0.0.1:1238';

if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

