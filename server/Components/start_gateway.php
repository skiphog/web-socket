<?php

use \Workerman\Worker;
use \GatewayWorker\Gateway;

require_once __DIR__ . '/../../vendor/autoload.php';

$gateway = new Gateway('websocket://0.0.0.0:8000');
$gateway->name = 'Gateway';
$gateway->count = 4;
$gateway->lanIp = '127.0.0.1';
$gateway->startPort = 2900;
$gateway->registerAddress = '127.0.0.1:1238';

// Ping <=> Pong
$gateway->pingInterval = 55;
$gateway->pingNotResponseLimit = 1;
$gateway->pingData = '';

/*$gateway->onConnect = function ($connection) {
    $connection->onWebSocketConnect = function ($connection, $http_header) {
        if ($_SERVER['HTTP_ORIGIN'] !== 'http://socket') {
            $connection->close();
        }
        var_dump($_GET, $_SERVER);
    };
};*/

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

