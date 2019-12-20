<?php
// 普通方法并发执行,这里之所以不用go，因为短标签被关闭
// 并发执行执行效率不是t1+t2,而是max(t1,t2)
Swoole\Coroutine::create(function(){
    sleep(1);
    echo 'b';
});

Swoole\Coroutine::create(function(){
    sleep(2);
    echo 'c';
});