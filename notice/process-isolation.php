<?php
// 进程隔离：在多进程服务器中，进程之间的变量时隔离的互不影响。
// 但是在同一个进程中不同请求次数却是同一个变量。
/*$httpServer = new Swoole\Http\Server('0.0.0.0', 8080);
$i = 1;
$httpServer->on('Request', function($request, $response){
    global $i;
    $response->end($i++);
});
$httpServer->start();*/
// 正确的做法是使用swoole提供的Swoole\Atomic或Swoole\Table数据结构在保存数据
// Swoole\Atomic数据是建立在共享内存之上的，使用add方法加1时，其他工作进程也能读到。
$httpServer = new \Swoole\Http\Server('0.0.0.0', 8080);
$atomic = new Swoole\Atomic(1);
$httpServer->on('Request', function($request, $response) use ($atomic){
    $response->end($atomic->add(1));
});
$httpServer->start();

