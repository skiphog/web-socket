<?php

namespace App;

use Workerman\Connection\ConnectionInterface;

class ConnectionsPool
{
    private $connections;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage();
    }

    public function add(ConnectionInterface $connection): void
    {
        $connection->write('Welcome to HELL' . PHP_EOL);
        $connection->write('Enter your name:');

        $this->setConnectionName($connection, '');
        $this->initEvents($connection);
    }

    /**
     * @param ConnectionInterface $connection
     */
    private function initEvents(ConnectionInterface $connection): void
    {
        $connection->on('data', function ($data) use ($connection) {
            if (!$name = $this->getConnectionName($connection)) {
                $this->addNewMember($connection, $data);

                return;
            }

            $this->sendAll("{$name}: {$data}" . PHP_EOL, $connection);
        });

        $connection->on('close', function () use ($connection) {
            $name = $this->getConnectionName($connection);
            $this->connections->offsetUnset($connection);

            $this->sendAll("{$name} HAS BEEN DEAD" . PHP_EOL, $connection);
        });
    }

    private function sendAll($message, ConnectionInterface $connection): void
    {
        foreach ($this->connections as $conn) {
            $conn !== $connection && $conn->write($message);
        }
    }

    private function addNewMember(ConnectionInterface $connection, $name): void
    {
        $name = str_replace(["\n", "\r"], '', $name);
        $this->setConnectionName($connection, $name);
        $this->sendAll("User {$name} join to chat" . PHP_EOL, $connection);
    }

    private function getConnectionName(ConnectionInterface $connection)
    {
        return $this->connections->offsetGet($connection);
    }

    private function setConnectionName(ConnectionInterface $connection, $name): void
    {
        $this->connections->offsetSet($connection, $name);
    }
}
