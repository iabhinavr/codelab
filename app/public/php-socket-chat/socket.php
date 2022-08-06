<?php

$address = '0.0.0.0';
$port = 8060;
$null = NULL;

include 'functions.php';

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($sock, $address, $port);
socket_listen($sock);


$clients = [];
$clients[] = $sock;

echo "Listening for new connections on port $port: " . "\n";

while(true) {

    $reads = $writes = $exceptions = $clients;
    socket_select($reads, $writes, $exceptions, 0);

    if(in_array($sock, $reads)) {
        $newclient = socket_accept($sock);
        $header = socket_read($newclient, 1024);     
        handshake($header, $newclient, $address, $port);
        $clients[] = $newclient;   
        $first_reply = "Hello, Welcome to the chat server!" . "\n";
        $first_reply = pack_data($first_reply);
        socket_write($newclient, $first_reply, strlen($first_reply));
        $firstIndex = array_search($sock, $reads);
        unset($reads[$firstIndex]);
    }

    foreach ($reads as $k => $v) { echo count($reads) . "\n";

        $bytes = socket_recv($v, $data, 1024, 0);
        if($bytes > 0) {
            $message = unmask($data);
            $decoded_message = json_decode($message, true);
            if ($decoded_message) {
                if(isset($decoded_message['name']) && isset($decoded_message['text'])){
                    $maskedMessage = pack_data(json_encode($decoded_message));
                    foreach ($clients as $ck => $cv) {
                        if($ck === 0) continue;
                        socket_write($cv, $maskedMessage, strlen($maskedMessage));
                    }
                }
            }
            break;
        }
            
        $check = @socket_read($v, 1024, PHP_NORMAL_READ);
        if($check === false)  {
            echo "disconnected " . $k . " \n";
            $index = array_search($v, $clients); echo $index . "\n";
            unset($clients[$index]);
            socket_close($v);
        }
    }

}

socket_close($sock);