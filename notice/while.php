<?php
// while死循环对swoole的影响
// 用两个tcp客户单连接服务器，只能一个连接成功。并且还会报错。
$tcpServer = new swoole_server('0.0.0.0', 8080);
$tcpServer->set(['worker_num' => 1]);
$i = 1;
$tcpServer->on('receive', function($tcpServer, $fd, $reactorId, $data) use ($i){
    while (1) {
        $i++;
        $tcpServer->send($fd, '6666：' . $data);
    }
});
$tcpServer->start();