<?php

namespace PHPOxford\SpiresIrc;

use PHPOxford\SpiresIrc\Irc\Connection;
use PHPOxford\SpiresIrc\Irc\User;

class IrcClient
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var User
     */
    private $user;

    private $socket;

    public function __construct(Connection $connection, User $user)
    {
        $this->connection = $connection;
        $this->user = $user;
    }

    public function connection() : Connection
    {
        return $this->connection;
    }

    public function user() : User
    {
        return $this->user;
    }

    public function socket()
    {
        return $this->socket;
    }

    public function connect()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $isConnected = socket_connect(
            $this->socket,
            $this->connection()->server(),
            $this->connection()->port()
        );

        socket_write($this->socket, "NICK {$this->user()->nickname()}\r\n");
        socket_write($this->socket, "USER {$this->user()->username()} {$this->user()->usermode()} * :{$this->user()->realname()}\r\n");
        socket_write($this->socket, "JOIN {$this->connection()->channel()}\r\n");
    }

    public function read()
    {
        return socket_read($this->socket, 2048, PHP_NORMAL_READ);
    }

    public function write(string $response)
    {
        return socket_write($this->socket, $response);
    }
}
