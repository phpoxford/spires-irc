<?php

use PHPOxford\SpiresIrc\Irc\Commands\Command;
use PHPOxford\SpiresIrc\Irc\Commands\Ping;
use PHPOxford\SpiresIrc\Irc\Commands\Pong;
use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;
use PHPOxford\SpiresIrc\Irc\Connection;
use PHPOxford\SpiresIrc\Irc\Message;
use PHPOxford\SpiresIrc\Irc\Message\Prefix;
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
        '##martinsbottesting',
        'irc.freenode.com'
    ),
    new User(
        'spires',
        'spires',
        'Spires ALPHA'
    )
);

$client->connect();

$parser = new \PHPOxford\SpiresIrc\Irc\Parser();

while ($raw = $client->read()) {

    if (!$raw = trim($raw)) {
        continue;
    }
    echo "\n\n";
    echo "Raw: {$raw}";
    echo "\n";
    $message = $parser->parse($raw . "\r\n");
    var_export($message);

    $prefix = new Prefix($message['nickname'], $message['username'], $message['hostname'], $message['servername']);

    switch ($message['command']) {
        case 'PING':
            $message = new Message(
                $prefix,
                Ping::fromParams($message['params'])
            );
            break;

        case 'PRIVMSG':
            $message = new Message(
                $prefix,
                Privmsg::fromParams($message['params'])
            );
            break;

        default:
            $message = new Message(
                $prefix,
                new Command($message['command'], $message['params'])
            );
    }
    echo "\n";
    var_dump($message);


    if ($message instanceof Ping) {
        $response = Pong::fromParams($message['params']);
        $client->write($response . "\r\n");
        echo "\n".'[response]: ' . $response;
    }

    if ($message instanceof Privmsg) {
//        list($target, $msg) = explode(' :', $message['params'], 2);

        if (in_array($client->connection()->channel(), $message->targets()) && strpos($message->text(), "hi spires") === 0) {
            $response = "PRIVMSG {$client->connection()->channel()} :Hello {$message->prefix()->nickname()}\r\n";
            $client->write($response);
            echo "\n".'[response]: ' . $response;
        }
        if (in_array($client->connection()->channel(), $message->targets()) && strpos($message->text(), '!spires') !== false) {
            $response = "PRIVMSG {$client->connection()->channel()} :Sorry {$message->prefix()->nickname()}, I'm stupid and can only say hello :(\r\n";
            $client->write($response);
            echo "\n".'[response]: ' . $response;
        }
    }
}




//// Edit these settings
//$chan = "#php";
//$server = "127.0.0.1";
//$port = 6667;
//$nick = "PHP_Bot";
//
//// STOP EDITTING NOW.
//$socket = fsockopen("$server", $port);
//fputs($socket,"USER $nick $nick $nick $nick :$nick\n");
//fputs($socket,"NICK $nick\n");
//fputs($socket,"JOIN ".$chan."\n");
//
//while(1) {
//    while($data = fgets($socket)) {
//        echo nl2br($data);
//        flush();
//
//        $ex = explode(' ', $data);
//        $rawcmd = explode(':', $ex[3]);
//        $oneword = explode('<br>', $rawcmd);
//        $channel = $ex[2];
//        $nicka = explode('@', $ex[0]);
//        $nickb = explode('!', $nicka[0]);
//        $nickc = explode(':', $nickb[0]);
//
//        $host = $nicka[1];
//        $nick = $nickc[1];
//        if($ex[0] == "PING"){
//            fputs($socket, "PONG ".$ex[1]."\n");
//        }
//
//        $args = NULL; for ($i = 4; $i < count($ex); $i++) { $args .= $ex[$i] . ' '; }
//
//        if ($rawcmd[1] == "!sayit") {
//            fputs($socket, "PRIVMSG ".$channel." :".$args." \n");
//        }
//        elseif ($rawcmd[1] == "!md5") {
//            fputs($socket, "PRIVMSG ".$channel." :MD5 ".md5($args)."\n");
//        }
//    }
//}
