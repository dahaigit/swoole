<?php

// 创建一个异步服务器,支持TCP,UDP,UnixSocket协议
try {
    $tcpServer = new Swoole\Server('0.0.0.0', 8080,SWOOLE_BASE, SWOOLE_SOCK_TCP);

    // 设置运行时参数
    $tcpServer->set([
        'worker_num' => 4,
        'daemonize' => 0,
        'backlog' => 128
    ]);

    // 注册事件回调函数
    $tcpServer->on('Connect', function () {
        echo '连接上了';
    });
    $tcpServer->on('Receive', function (){
        echo '接收到消息了';
    });
    $tcpServer->on('Close', function(){
        echo "连接关闭了";
    });
    echo '重启';

//    $tcpServer->reload();

    // 启动服务器
    $tcpServer->start();



}catch (\Exception $exception) {
    echo '连接失败';
    throw $exception;
}
















