<?php
/**
 * 可以监听多个端口，实际应用场景分内外网监听端口
 */
$listenerServer = new \Swoole\Server('192.168.10.10', 8083);

$listenerServer->on('receive', function ($server, $fd, $from_id, $data) {
    $info = $server->getClientInfo($fd, $from_id);
    var_dump($info);
    if ($info['server_port'] == 8083) {
        // 来自外网的数据
        $server->send($fd, '外网 from:' . $data);
    } else {
        // 来自内网的数据
        $server->send($fd, '内网 from:' . $data);
    }
});
$listenerServer->addListener('127.0.0.1', 8084, SWOOLE_SOCK_TCP);
$listenerServer->start();

