<?php

namespace PHPOxford\SpiresIrc\Irc;

use PHPOxford\SpiresIrc\Irc\Message\Prefix;
use PHPOxford\SpiresIrc\Irc\Message\Command;

class Message
{
    /**
     * @var Prefix
     */
    private $prefix;

    /**
     * @var Command
     */
    private $command;

    public function __construct(Prefix $prefix, Command $command)
    {
        $this->prefix = $prefix;
        $this->command = $command;
    }

    public function prefix() : Prefix
    {
        return $this->prefix;
    }

    public function command() : Command
    {
        return $this->command;
    }

    public function raw()
    {
        return trim($this->prefix->raw() . ' ' . $this->command->raw());
    }
}
