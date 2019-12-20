<?php
$http = new swoole_http_server('0.0.0.0', 8086);
$http->on('request', function($request, $response){
    $db = new Swoole\Coroutine\MySQL();
    $db->connect([
        'host' => '127.0.0.1',
        'port' => '3306',
        'user' => 'homestead',
        'password' => 'secret',
        'database' => 'xyhenggong.com',
    ]);
    $data = $db->query('show tables');
    $response->end(json_encode($data));
});
$http->start();