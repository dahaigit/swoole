<?php
// Throwable可以捕捉到所有可捕捉的异常
try {
    test();
}
catch(Throwable $e) {
    var_dump($e);
}