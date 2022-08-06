<?php

use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;

$server = new Server("0.0.0.0", 9502);

$server->on("Start", function (Server $server){
    echo "Swoole socket is started on port 9502, listening for connections";
});

$server->on("Open", function(Server $server, Swoole\HTTP\Request $request){
    echo "Connection open: {$request->fd}\n";
    $server->tick(1000, function() use ($server, $request){
        $server->push($request->fd, json_encode(["hello", time()]));
    });
});

$server->on("Message", function(Server $server, Frame $frame){
    echo "received message: {$frame->data}\n";
    $server->push($frame->fd, json_encode(["hello", time()]));
});

$server->on("Close", function(Server $server, int $fd){
    echo "connection close: {$fd}\n";
});

$server->on("Disconnect", function(Server $server, int $fd){
    echo "connection disconnect: {$fd}\n";
});

$server->start();