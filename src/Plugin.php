<?php
declare(strict_types=1);

namespace PHPOxford\SpiresIrc;

use PHPOxford\SpiresIrc\Irc\Message;

interface Plugin
{
    public function handle(IrcClient $client, Message $message);
}
