<?php
$tcpServer = new Swoole\Server('127.0.0.1', 8080);

$tcpServer->on('Connect', function ($tcpServer, $fd){
    echo "监听了\n";
});

$tcpServer->on('Receive', function ($tcpServer, $fd, $from_id, $data){
    $tcpServer->send($fd, '服务器接收到数据了：' . $data . 'fromId:' . $from_id. "fd:" );
});

$tcpServer->on('Close', function($tcpServer, $fd){
    echo '客户端关闭了\n'. "fd:" . $fd;
});

$tcpServer->start();













