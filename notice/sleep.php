<?php
// 原生sleep/usleep对swoole的影响
$tcpServer = new swoole_server('0.0.0.0', 8087);
$tcpServer->set(['worker_num' => 1]);
$tcpServer->on('receive', function ($tcpServer, $fd, $from_id, $data){
//    sleep(10);
    swoole_timer_after(10000 ,function() use ($tcpServer, $fd, $data){
        $tcpServer->send($fd, 'Swoole:' . $data);
    });
});
$tcpServer->start();
// 1、当sleep开启后，实践只能有一个telnet客户端连接到服务器
// telnet 192.168.10.10 8087s
// 2、当使用swoole_timer_after以后就可以连接多个telnet客户端了。