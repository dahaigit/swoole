<?php
$httpServer = new swoole_http_server('0.0.0.0', 8083);

$httpServer->on('request', function($request, $response){
    // 过滤掉icon请求
    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end();
    }
    var_dump($request->get, $request->post);
    $response->header('Content-Type', 'text/html; charset=utf-8');
    $response->end('hello world swoole');
});

$httpServer->start();




