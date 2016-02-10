<?php

namespace PHPOxford\SpiresIrc;

use PHPOxford\SpiresIrc\Irc\Message;

interface Plugin
{
    public function handle(IrcClient $client, Message $message);
}
