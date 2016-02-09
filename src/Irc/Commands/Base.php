<?php

namespace PHPOxford\SpiresIrc\Irc\Commands;

use PHPOxford\SpiresIrc\Irc\Message\Command as CommandInterface;

abstract class Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command;

    public function command() : string
    {
        return $this->command;
    }

    public function __toString() : string
    {
        return trim($this->command() . ' ' . $this->params());
    }
}
