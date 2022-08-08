<?php

$address = '0.0.0.0';
$port = 8060;
$null = NULL;

include 'functions.php';

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($sock, $address, $port);
socket_listen($sock);

$members = [];
$connections = [];
$connections[] = $sock;

echo "Listening for new connections on port $port: " . "\n";

while(true) {

    $reads = $writes = $exceptions = $connections;
    socket_select($reads, $writes, $exceptions, 0);

    if(in_array($sock, $reads)) {
        $new_connection = socket_accept($sock);
        $header = socket_read($new_connection, 1024);     
        handshake($header, $new_connection, $address, $port);
        $connections[] = $new_connection;
        $reply = [
            "type" => "notification",
            "sender" => "Server",
            "text" => "enter name to join... \n"
        ];
        $reply = pack_data(json_encode($reply));
        socket_write($new_connection, $reply, strlen($reply));
        $firstIndex = array_search($sock, $reads);
        unset($reads[$firstIndex]);
    }

    foreach ($reads as $k => $v) {

        $data = socket_read($v, 1024);

        if(!empty($data)) {
            $message = unmask($data);
            $decoded_message = json_decode($message, true);
            if ($decoded_message) {
                if(isset($decoded_message['text'])){
                    if($decoded_message['type'] === 'join') {
                        $members[$k] = [
                            'name' => $decoded_message['sender'],
                            'connection' => $v
                        ];
                    }
                    $maskedMessage = pack_data($message);
                    foreach ($members as $mk => $mv) {
                        socket_write($mv['connection'], $maskedMessage, strlen($maskedMessage));
                    }
                }
            }
        }

        else if($data === '')  {
            echo "disconnected " . $k . " \n";
            // $index = array_search($v, $connections);
            unset($connections[$k]);
            if(array_key_exists($k, $members)) {
                
                $message = [
                    "type" => "left",
                    "sender" => "system",
                    "text" => $members[$k]['name'] . " left the chat \n"
                ];
                $maskedMessage = pack_data(json_encode($message));
                unset($members[$k]);
                foreach ($members as $mk => $mv) {
                    socket_write($mv['connection'], $maskedMessage, strlen($maskedMessage));
                }
            }
            socket_close($v);
        }
    }

}

socket_close($sock);