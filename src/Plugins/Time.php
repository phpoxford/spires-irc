<?php

namespace PHPOxford\SpiresIrc\Plugins;

use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\IrcClient;
use PHPOxford\SpiresIrc\Plugin;

class Time implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Privmsg) {
            /** @var Privmsg $command */
            $command = $message->command();

            if ($command->hasTarget($client->channel())) {
                if (preg_match('/^!?spires,? what time is it\??/i', $command->text())) {
                    $time = date('H:i');
                    $client->channelMessage(" \\o/  /       {$time}       \\");
                    $client->channelMessage("  |   \\ It's hammer time! /");
                    $client->channelMessage(" / \\");
                }
            }
        }
    }
}
