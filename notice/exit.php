<?php
// 禁止使用exit/die。
function swoole_exit($msg)
{
    throw new ExitException($msg);
}
class ExitException extends \Exception {
}
$tcpServer = new swoole_server('0.0.0.0', 8088);
$tcpServer->set(['worker_num' => 1]);
$tcpServer->on('receive', function ($tcpServer, $fd, $from_id, $data){
    swoole_exit('自定义退出');
    $tcpServer->send($fd, 'Swoole:' . $data);
});
$tcpServer->start();