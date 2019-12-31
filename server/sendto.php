<?php

$server = new \Swoole\Server('192.168.10.10', '8081');

$server->on('receive', function($server, $fd, $reactor_id, $data){
    var_dump(trim($data));
    $server->sendto('220.181.57.216', 8080, 'hello world');
});
$server->start();


























