<?php
declare(strict_types=1);

namespace PHPOxford\SpiresIrc\Irc\Message;

use PHPOxford\SpiresIrc\Irc\Message\Command as CommandInterface;

interface Command
{
    public static function fromParams(string $params);

    public function command() : string;

    public function params() : string;

    public function __toString() : string;
}
