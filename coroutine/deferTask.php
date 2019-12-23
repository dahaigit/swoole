<?php
/**
 * 延迟任务
 */
Swoole\Coroutine::create(function(){
    echo 1;
    // defer因为短标签所以执行不了
    swoole_event_defer(function(){
        echo 2;
    });
    echo 3;
    swoole_event_defer(function(){
        echo 4;
    });
    sleep(1);
    echo 5;
});
// 执行结果：13524，我猜的结果是13245。



