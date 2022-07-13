<?php

$address = '127.0.0.1';
$port = 8060;
$null = NULL;

include 'functions.php';

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($sock, 0, $port);
socket_listen($sock);


$clients = [];
$clients[] = $sock;

echo "Listening for new connections on port $port: " . "\n";

while(true) {

    $r = $w = $e = $clients;
    socket_select($r, $w, $e, 0, 10);

    if(in_array($sock, $r)) {

        $newclient = socket_accept($sock);

        $header = socket_read($newclient, 1024); 
    
        wshandshake($header, $newclient, $address, $port);

        $clients[] = $newclient;
    
        $first_reply = "Hello, Welcome to the chat server!" . "\n";
        $first_reply = mask($first_reply);
        socket_write($newclient, $first_reply, strlen($first_reply));

        $firstIndex = array_search($sock, $r);
        unset($r[$firstIndex]);
    }

    foreach ($r as $v) {
        $message = '';
        if(socket_recv($v, $data, 1024, 0) >= 1){
            $message = unmask($data);
            if($message) {
                echo $message;
                $maskedMessage = mask($message);
                for ($i = 1; $i < count($clients); $i++) {
                    socket_write($clients[$i], $maskedMessage, strlen($maskedMessage));
                }
            }
        } 
    }

}

socket_close($sock);