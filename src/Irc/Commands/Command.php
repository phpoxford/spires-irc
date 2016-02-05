<?php

namespace PHPOxford\SpiresIrc\Irc\Commands;

use PHPOxford\SpiresIrc\Irc\Message\Command as CommandInterface;

class Command implements CommandInterface
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $params;

    public function __construct(string $command, string $params = null)
    {
        $this->command = $command;
        $this->params = $params ?: '';
    }

    public function command() : string
    {
        return $this->command;
    }

    public function params() : string
    {
        return $this->params;
    }

    public function raw() : string
    {
        return trim($this->command() . ' ' . $this->params());
    }
}
