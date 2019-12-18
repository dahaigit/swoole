<?php
$ws = new swoole_websocket_server('0.0.0.0', 8084);

$ws->on('open', function($ws, $request){
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, 'hello world webSocket\n');
});

$ws->on('message', function($ws, $frame){
    echo 'message:' . $frame->data;
    $ws->push($frame->fd, '服务器搜到消息了：' . $frame->data);
});

$ws->on('close', function($ws, $fd){
    echo 'client-' . $fd . ' closed\n';
});

$ws->start();



























