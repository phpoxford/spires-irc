<?php

use PHPOxford\SpiresIrc\Irc\Connection;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\Irc\User;
use PHPOxford\SpiresIrc\IrcClient;
use PHPOxford\SpiresIrc\Plugins\Greetings;
use PHPOxford\SpiresIrc\Plugins\PingPong;
use PHPOxford\SpiresIrc\Plugins\Time;

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting as it comes in. */
ob_implicit_flush();

$client = new IrcClient(
    new Connection(
        '#phpoxford',
//        '##martinsbottesting',
        'irc.freenode.com'
    ),
    new User(
        'spires',
        'spires',
        'Spires ALPHA'
    )
);

$client->connect();


// Ping Pong
$client->addPlugin(new PingPong());

// (hi|hello|hey) spires
$client->addPlugin(new Greetings());

// !spires what time is it?
$client->addPlugin(new Time());


$client->run();
