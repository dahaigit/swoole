<?php
$tcpClient = new swoole_client(SWOOLE_SOCK_TCP);

$tcpClient->connect('127.0.0.1', 8080) or die('connect error');

fwrite(STDOUT, '请输入信息');

$msg = trim(fgets(STDIN));

$tcpClient->send($msg, '11212');

$result = $tcpClient->recv();
echo  $result;























