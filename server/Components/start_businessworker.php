<?php

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;

require_once __DIR__ . '/../../vendor/autoload.php';

$worker = new BusinessWorker();
$worker->name = 'BusinessWorker';
$worker->count = 4;
$worker->registerAddress = '127.0.0.1:1238';
$worker->eventHandler = \App\Events::class;

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
