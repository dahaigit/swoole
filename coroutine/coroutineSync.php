<?php

/**
 * 协程同步
 */
class WaitGroup
{
    private $count = 0;

    private $chan;

    public function __construct()
    {
        $this->chan = new \Swoole\Coroutine\Channel(2);
    }

    /**
     * Notes: 方法增加计数
     * User: mhl
     */
    public function add()
    {
        $this->count++;
    }

    /**
     * Notes: 表示任务已完成
     * User: mhl
     */
    public function done()
    {
        $this->chan->push(true);
    }

    /**
     * Notes: 等待所有任务完成恢复当前协程的执行
     * User: mhl
     */
    public function wait()
    {
        while ($this->count--) {
            $this->chan->pop();
        }
    }
}
// 注意：这里用到了swoole的ssl插件，若按照的时候没有勾选，则用pecl重新安装swoole
Swoole\Coroutine::create(function(){
    $waitGroup = new WaitGroup();
    $results = [];
    $waitGroup->add();
    // 启动第一个协程
    Swoole\Coroutine::create(function() use ($waitGroup, &$results) {
        $cli = new Swoole\Coroutine\Http\Client('www.taobao.com', 433, true);
        $cli->setHeaders([
            'Host' => "www.taobao.com",
            "User-Agent" => 'Chrome/49.0.2587.3',
            'Accept' => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ]);
        $cli->set(['timeout' => 1]);
        $cli->get('/index.php');

        $results['taobao'] = $cli->body;
        $cli->close();

        $waitGroup->done();
    });

    $waitGroup->add();
    // 启动第二个协程
    \Swoole\Coroutine::create(function() use ($waitGroup, &$results){
        $cli = new Swoole\Coroutine\Http\Client('www.baidu.com', 443, true);
        $cli->setHeaders([
            'Host' => "www.baidu.com",
            "User-Agent" => 'Chrome/49.0.2587.3',
            'Accept' => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ]);
        $cli->set(['timeout' => 1]);
        $cli->get('/index.php');

        $results['baidu'] = $cli->body;
        $cli->close();

        $waitGroup->done();
    });

    // 挂起当前协程，等待所有子任务完成后执行。
    $waitGroup->wait();
    // 打印2个子协程结果
    var_dump($results);
    // 结果是：淘宝的没有抓取到数据，百度的可以。
});













