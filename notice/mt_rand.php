<?php
// 随机函数该如何使用
echo mt_rand(0, 1) . PHP_EOL;

$worker_num = 16;
for ($i = 0; $i < $worker_num; $i++) {
    $process = new swoole_process('child_async', false, 2);
    $pid = $process->start();
}

function child_async(swoole_process $worker) {
    mt_srand();
    echo mt_rand(0, 100) . PHP_EOL;
    $worker->exit();
}
// 若没有mt_srand结果：1,2,2...
// 若同时没有主进程的mt_rand和mt_srand时结果：2,35,15...
// 若同时有的时候，表现为正常












