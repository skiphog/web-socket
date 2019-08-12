<?php

use GatewayClient\Gateway as GatewayClient;

require __DIR__ . '/../vendor/autoload.php';

if (isset($_POST['message'])) {
    try {
        GatewayClient::$registerAddress = '127.0.0.1:1238';
        GatewayClient::sendToAll(json_encode([
            'type' => 'message',
            'message' => htmlspecialchars($_POST['message']),
        ], JSON_UNESCAPED_UNICODE));
    } catch (Exception $e) {
    }
}