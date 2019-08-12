<?php
/**
 * @noinspection PhpUnused
 */

namespace App;

use Exception;
use \GatewayWorker\Lib\Gateway;

/**
 * Class Events
 */
class Events
{

    /**
     * @var
     */
    public static $db;

    public static function onWorkerStart($worker)
    {
        //self::$db = new \Workerman\MySQL\Connection('host', 'port', 'user', 'password', 'db_name');
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param string $client_id 连接id
     *
     * @throws Exception
     */
    public static function onConnect(string $client_id)
    {

        /*Gateway::sendToClient($client_id, json_encode([
            'type'      => 'init',
            'client_id' => $client_id,
        ]));*/

        Gateway::sendToCurrentClient(json_encode([
            'type'      => 'init',
            'client_id' => $client_id,
        ]));
    }

    public static function onWebSocketConnect(string $client_id, array $data)
    {
        /*Gateway::sendToCurrentClient(json_encode($data));

        if (!isset($data['get']['token'])) {
            Gateway::closeClient($client_id);
        }*/
    }

    /**
     * 当客户端发来消息时触发
     *
     * @param int   $client_id 连接id
     * @param mixed $message 具体消息
     *
     * @throws Exception
     */
    public static function onMessage($client_id, $message)
    {
        $data = json_decode($message, true);

        if ($data['type'] === 'write') {
            Gateway::sendToAll(json_encode([
                'type' => 'write'
            ]));
        }
    }

    /**
     * 当用户断开连接时触发
     *
     * @param int $client_id 连接id
     *
     * @throws Exception
     */
    public static function onClose($client_id)
    {
        //$user_id = $_SESSION['uid'];

        //print_r($user_id);
        // 向所有人发送
        //GateWay::sendToAll(json_encode([$user_id, $client_id]));
    }
}
