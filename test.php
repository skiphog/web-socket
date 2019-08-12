<?php

session_start();

use GatewayClient\Gateway;

require __DIR__ . '/vendor/autoload.php';

Gateway::$registerAddress = '127.0.0.1:1238';

/*Gateway::bindUid('7f0000010b5400000001', 1);
Gateway::bindUid('7f0000010b5400000002', 2);

Gateway::setSession('7f0000010b5400000001', ['uid' => 1]);
Gateway::setSession('7f0000010b5400000002', ['uid' => 2]);*/


//$data = Gateway::getAllClientIdList();
//$data = Gateway::getClientIdByUid(71268);
//$data = Gateway::isUidOnline(522);

//$data = Gateway::getAllClientIdList();
if ((bool)Gateway::isUidOnline(2)) {
    Gateway::sendToUid(2, 'Ахуенчик');
}

if ((bool)Gateway::isUidOnline(1)) {
    Gateway::sendToUid(1, 'Пошел нахуй отсюда петушок');
}

$data = Gateway::getAllClientSessions();

//Gateway::sendToUid(71268, 'Иди ты нахуй пидараст');

//$data = Gateway::getAllClientSessions();

print_r($data);
exit(0);
