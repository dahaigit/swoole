<?php

class DeferDestruct
{
    private $tasks;

    function add(callable $fn)
    {
        $this->tasks[] = $fn;
    }

    function __destruct()
    {
        // 反转
        // 把数组元素排序反转
        $tasks = array_reverse($this->tasks);
        foreach ($tasks as $task)
        {
            $task();
        }
    }
}

function test(){
    $deferTask = new DeferDestruct();

    $deferTask->add(function(){
        echo 'code 1';
    });

    $deferTask->add(function(){
        echo 'code 2';
    });
    return $deferTask;
}

var_dump(test());




