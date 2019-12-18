<?php
swoole_timer_tick(2000, function(){
    echo "每隔2秒执行一次，第一次执行是在2秒后。";
});

swoole_timer_after(3000, function(){
    echo '3秒后执行，并且只执行一次。';
});
