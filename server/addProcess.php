<?php
// 添加进程，进行一些特殊任务
$server = new Swoole\Server('127.0.0.1', 8083);
// 用户进程实现了广播功能，循环接收管道消息，并发送给服务器的所有连接。
$process = new Swoole\Process(function($process) use ($server) {
    while (true) {
        $msg = $process->read();
        foreach ($server->connections as $conn)
        {
            $server->send($conn, $msg);
        }
    }
});
$server->addProcess($process);
$server->on('receive', function($server, $fd, $reactory_id, $data) use ($process) {
    // 群发收到的消息
    $process->write($data);
});
$server->start();

