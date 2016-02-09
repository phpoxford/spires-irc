<?php

use PHPOxford\SpiresIrc\Irc\Commands\Ping;
use PHPOxford\SpiresIrc\Irc\Commands\Pong;
use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;
use PHPOxford\SpiresIrc\Irc\Connection;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\Irc\User;
use PHPOxford\SpiresIrc\IrcClient;

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
$client->addAction(function (IrcClient $client, Message $message) {
    if ($message->command() instanceof Ping) {
        $response = Pong::fromParams($message->command()->params());
        $client->write($response);
    }
});

// (hi|hello|hey) spires
$client->addAction(function (IrcClient $client, Message $message) {
    if ($message->command() instanceof Privmsg) {

        /** @var Privmsg $command */
        $command = $message->command();

        if ($command->hasTarget($client->channel())) {
            if (preg_match('/^(hi|hello|hey) spires$/i', $command->text())) {
                $response = new Privmsg([$client->channel()], "Hello {$message->prefix()->nickname()}");
                $client->write($response);
            }
        }
    }
});

// !spires what time is it?
$client->addAction(function (IrcClient $client, Message $message) {
    if ($message->command() instanceof Privmsg) {
        /** @var Privmsg $command */
        $command = $message->command();

        if ($command->hasTarget($client->channel())) {
            if (preg_match('/^!spires (?P<match>.+)/i', $command->text(), $matches)) {
                if (preg_match('/^what time is it\??/i', $matches['match'])) {
                    $client->write(new Privmsg([$client->channel()], "It's"));
                    $dancer = '     \o/';
                    foreach ([1,2,3] as $i) {
                        usleep(1000000/$i);
                        $client->write(new Privmsg([$client->channel()], substr($dancer, -1*$i, $i)));
                        $dancer = $dancer == '     \o/' ? '     /o\\' : '     \o/';
                    }
                    ++$i;
                    usleep(1000000/$i);
                    $client->write(new Privmsg([$client->channel()], substr($dancer, -1*$i, $i) . " HAMMER TIME!"));
                }
            }
        }
    }
});

$client->run();
