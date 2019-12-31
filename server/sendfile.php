<?php

$server = new \Swoole\Server('0.0.0.0', 8080);
$server->on('receive', function($server, $fd, $reactor_id, $data){
    var_dump(trim($data));
    if (trim($data) == 'sendfile') {
        echo '发送文件了';
        $server->sendfile($fd, 'reload.rar');
        echo '发送邮件end';
    } else {
        $server->send($fd, '收到消息');
    }
});
$server->start();