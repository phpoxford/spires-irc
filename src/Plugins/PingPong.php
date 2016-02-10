<?php

namespace PHPOxford\SpiresIrc\Plugins;

use PHPOxford\SpiresIrc\Irc\Commands\Ping;
use PHPOxford\SpiresIrc\Irc\Commands\Pong;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\IrcClient;
use PHPOxford\SpiresIrc\Plugin;

class PingPong implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Ping) {
            $response = Pong::fromParams($message->command()->params());
            $client->write($response);
        }
    }
}
