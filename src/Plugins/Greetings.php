<?php

namespace PHPOxford\SpiresIrc\Plugins;

use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\IrcClient;
use PHPOxford\SpiresIrc\Plugin;

class Greetings implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Privmsg) {
            /** @var Privmsg $command */
            $command = $message->command();

            if ($command->hasTarget($client->channel())) {
                if (preg_match('/^(hi|hello|hey) spires$/i', $command->text())) {
                    $client->channelMessage("Hello {$message->prefix()->nickname()}");
                }
            }
        }
    }
}
