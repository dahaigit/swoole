<?php
// 设置运行时的各项参数。
// Swoole\Server
$tcpServer = new Swoole\Server('0.0.0.0', 8081);
$tcpServer->set([
    'max_conn' => 40, // 最大连接数
    'daemonize' => 0, // 守护进程
    'reactor_num' => 2, // 线程数
    'worker_num' => 4, // 进程数
    'max_request' => 5, // 最大链接后重启worker
    'backlog' => 3, // 最大同时等待接收的连接数
    'open_cpu_affinity' => 1, // cpu亲和设置
    'open_tcp_nodelay' => 1, // 启动tcp不延迟
    'tcp_defer_accept' => 5, // 设置accept推辞时间
    'log_file' => '/home/vagrant/code/mhl/swoole/log/swoole.log', // 日志目录
    // 开启buffer缓存后：
    //  1）cmd回车发送不了消息。
    //  2）若用client.php发送数据，若发生的消息没有结束符则client.php的recv()方法会警告
    //  PHP Warning:  Swoole\Client::recv(): recv() failed. Error: Resource temporarily unavailable
//    'open_eof_check' => true, // 数据buffer,
//    'package_eof' => '\r\n' // 设置eof
]);

$tcpServer->on('receive', function($tcpServer, $fd, $from_id, $data){
//    $tcpServer->send($fd, '收到消息:' . $data);
    echo "收到消息";
    $tcpServer->send($fd, '服务器接收到数据了：' . $data . 'fromId:' . $from_id. "fd:" );
});
// 启动服务器
$tcpServer->start();