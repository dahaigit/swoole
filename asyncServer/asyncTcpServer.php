<?php

$asyncTcpServer = new swoole_server('127.0.0.1', 8085);

// 设置异步任务的工作进程数量
$asyncTcpServer->set([
    'task_worker_num' => 4
]);

$asyncTcpServer->on('receive', function($asyncTcpServer, $fd, $from_id, $data){
    // 投递异步任务
    $taskId = $asyncTcpServer->task($data);
    echo 'dispath async task: id=' . $taskId;
});

// 处理异步任务
$asyncTcpServer->on('task', function($asyncTcpServer, $task_id, $from_id, $data){
    echo "New AsyncTask[id=$task_id]".PHP_EOL;
    //返回任务执行的结果
    $asyncTcpServer->finish("$data -> OK");
});

//处理异步任务的结果
$asyncTcpServer->on('finish', function ($asyncTcpServer, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
});

$asyncTcpServer->start();