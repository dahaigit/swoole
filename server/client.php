<?php
$tcpClient = new swoole_client(SWOOLE_SOCK_TCP);

$tcpClient->connect('192.168.10.10', 8081) or die('connect error');

fwrite(STDOUT, '请输入信息');

$msg = trim(fgets(STDIN));

$tcpClient->send($msg, '11212' );

$result = $tcpClient->recv();
echo  $result;























