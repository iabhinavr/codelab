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
        $reply = [
            "name" => "Server",
            "text" => "enter name to join... \n"
        ];
        $reply = pack_data(json_encode($reply));
        socket_write($newclient, $reply, strlen($reply));
        $firstIndex = array_search($sock, $reads);
        unset($reads[$firstIndex]);
    }

    foreach ($reads as $k => $v) {

        $data = @socket_read($v, 1024);

        if(!empty($data)) {
            $message = unmask($data);
            $decoded_message = json_decode($message, true);
            if ($decoded_message) {
                if(isset($decoded_message['name']) && isset($decoded_message['text'])){
                    $maskedMessage = pack_data($message);
                    foreach ($clients as $ck => $cv) {
                        if($ck === 0) continue;
                        socket_write($cv, $maskedMessage, strlen($maskedMessage));
                    }
                }
            }
        }

        else if($data === '')  {
            echo "disconnected " . $k . " \n";
            $index = array_search($v, $clients);
            unset($clients[$index]);
            socket_close($v);
        }
    }

}

socket_close($sock);