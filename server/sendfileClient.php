<?php
// 客户端接收到文件后保存起来
$client = new swoole_client(SWOOLE_SOCK_TCP);
$client->connect('192.168.10.10', 8080) or die('大哥，没有连接上tcp服务器');
$client->send('sendfile');
$res = $client->recv();
file_put_contents('res.rar', $res);
$client->close();