<?php

namespace PHPOxford\SpiresIrc\Plugins;

use PHPOxford\SpiresIrc\Irc\Commands\Join;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\IrcClient;
use PHPOxford\SpiresIrc\Plugin;

class Welcome implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Join && $message->prefix()->nickname() != $client->user()->nickname()) {
            $client->channelMessage("Welcome {$message->prefix()->nickname()} :D");
        }
    }
}
