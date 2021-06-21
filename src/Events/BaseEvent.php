<?php
namespace App\Events;

class BaseEvent {
    private static $events = [];

    public function listen($name, $callback) {
        self::$events[$name][] = $callback;
    }

    public function trigger($name, $argument = null) {
        foreach (self::$events[$name] as $event => $callback) {
            if($argument && is_array($argument)) {
                call_user_func_array($callback, $argument);
            }
            elseif ($argument && !is_array($argument)) {
                call_user_func($callback, $argument);
            }
            else {
                call_user_func($callback);
            }
        }
    }
}

 ?>