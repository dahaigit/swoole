<?php
$server = new Swoole\Server('127.0.0.1', 9501);
// 设置运行时参数
$server->set([
    'worker_num' => 4,
]);
// 监听连接事件
// fd 客户端连接的唯一标识
$server->on('connect', function($server, $fd, $reactor_id){
    echo '连接上了-' . $fd . '线程ID' . $reactor_id;
});

// 接收事件
$server->on('receive', function($server, $fd, $reactor_id, $data){
    $server->send($fd, 'data:' . $data . $reactor_id);
});

// 关闭事件
$server->on('close', function($server, $fd){
    echo "连接关闭了fd:" . $fd;
});
// 服务开启
$server->start();