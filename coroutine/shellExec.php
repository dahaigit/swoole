<?php

// 协程只需5秒
$a = 3;

while ($a--) {
    Swoole\Coroutine::create(function() use ($a){
        echo $a;
        \Swoole\Coroutine::exec('sleep 5');
    });
}

// 普通的shell执行需要等待15秒
$a = 3;
while ($a--) {
    echo $a;
    shell_exec('sleep 5');
}