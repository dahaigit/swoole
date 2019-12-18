<?php
$udpServer = new swoole_server('127.0.0.1', 8081, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

$udpServer->on('Packet', function($udpServer, $data, $clientInfo){
        $udpServer->sendto($clientInfo['address'], $clientInfo['port'], 'UDP server'. $data);
        var_dump($clientInfo);
});

$udpServer->start();