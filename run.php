<?php

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

//$channel = '#phpoxford';
$channel = '##martinsbottesting';
$server = 'irc.freenode.com';
$port = 6667;
$nickname = 'spires';
$realname = 'Spires ALPHA';


$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$isConnected = socket_connect($socket, $server, $port);

socket_write($socket, "NICK {$nickname}\r\n");
socket_write($socket, "USER {$nickname} {$nickname} {$nickname} :{$realname}\r\n");
socket_write($socket, "JOIN {$channel}\r\n");

$parser = new \PHPOxford\SpiresIrc\Irc\Parser();

while ($raw = socket_read($socket, 2048, PHP_NORMAL_READ)) {

    if (!$raw = trim($raw)) {
        continue;
    }
    echo "\n\n";
    $message = $parser->parse($raw . "\r\n");
    var_export($message);

    if ($message['command'] === 'PING') {
        $response = "PONG {$message['params']}\r\n";
        socket_write($socket, $response);
        echo '[response]: ' . $response;
    }

    if ($message['command'] === 'PRIVMSG') {
        list($target, $msg) = explode(' :', $message['params'], 2);

        if ($target === $channel && strpos($msg, "hi spires") === 0) {
            $response = "PRIVMSG {$channel} :Hello {$message['nickname']}\r\n";
            socket_write($socket, $response);
            echo '[response]: ' . $response;
        }
        if ($target === $channel && strpos($msg, '!spires') !== false) {
            $response = "PRIVMSG {$channel} :Sorry {$message['nickname']}, I'm stupid and can only say hello :(\r\n";
            socket_write($socket, $response);
            echo '[response]: ' . $response;
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
