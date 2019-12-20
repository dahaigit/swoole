<?php
// 协程通信：

// 这里不使用短标签chan
$chan = new Swoole\Coroutine\Channel(2);

Swoole\Coroutine::create(function() use ($chan){
    echo 'qq 1 |';
    $cli = new Swoole\Coroutine\Http\Client('www.qq.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => 'www.qq.com',
        'User-Agent' => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    echo 'qq 2 |';
    // $cli->body 响应内容过大，这里用 Http 状态码作为测试
    $chan->push([
        'www.qq.com' => $cli->statusCode
    ]);
    echo 'qq 3 |';
});

Swoole\Coroutine::create(function() use ($chan){
    echo '163 1 |';
    $cli = new Swoole\Coroutine\Http\Client('www.163.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => 'www.163.com',
        'User-Agent' => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    echo '163 2 |';
    // $cli->body 响应内容过大，这里用 Http 状态码作为测试
    $chan->push([
        'www.163.com' => $cli->statusCode
    ]);
    echo '163 3 |';
});

Swoole\Coroutine::create(function() use ($chan){
    echo 'for 1 |';
    $result = [];
    for ($i = 0; $i < 2; $i++) {
        echo 'for 2 |';
        $result += $chan->pop();
        echo 'for 3 |';
    }
    echo 'for 4 |';
    var_dump($result);
});
/*
 * 执行结果：
 * qq 1 |163 1 |for 1 |for 2 |qq 2 |for 3 |for 2 |qq 3 |163 2 |for 3 |for 4 |array(2) {
  ["www.qq.com"]=>
  int(302)
  ["www.163.com"]=>
  int(200)
}
 *
 * */


















































