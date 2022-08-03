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
        $first_reply = pack_data($first_reply);
        socket_write($newclient, $first_reply, strlen($first_reply));

        $firstIndex = array_search($sock, $r);
        unset($r[$firstIndex]);
    }

    foreach ($r as $k => $v) { echo "inside for loop \n";
        $message = '';
        $data = socket_read($v, 1024);
        if($data){
            $message = unmask($data);
            if($message) {
                echo $message . "\n";
                $maskedMessage = pack_data($message);
                foreach ($clients as $ck => $cv) {
                    if($ck === 0) continue;
                    socket_write($clients[$ck], $maskedMessage, strlen($maskedMessage));
                }
            }
        }
        else {
            echo "disconnected \n";
            $index = array_search($v, $clients); echo $index . "\n";
            unset($clients[$index]);
            socket_close($v);
        }
    }

}

socket_close($sock);