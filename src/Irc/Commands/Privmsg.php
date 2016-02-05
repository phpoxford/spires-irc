<?php

namespace PHPOxford\SpiresIrc\Irc\Commands;

class Privmsg extends Command
{
    /**
     * @var string
     */
    private $target;

    /**
     * @var string
     */
    private $text;

    public function __construct(string $params = null)
    {
        parent::__construct('PRIVMSG', $params);

        list($target, $text) = explode(' ', $params, 2);

        $this->target = $target;
        $this->text = ltrim($text, ':');
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

    public function target() : string
    {
        return $this->target;
    }

    public function text()
    {
        return $this->text;
    }
}
