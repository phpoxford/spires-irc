<?php

namespace PHPOxford\SpiresIrc\Irc\Message;

interface Command
{
    public function command() : string;

    public function params() : string;

    public function raw() : string;
}
