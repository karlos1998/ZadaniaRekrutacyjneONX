<?php

class Pipeline {
    private static $functions = [];

    public static function make(...$functions) {
        self::$functions = $functions;
        return fn($arg) => self::run($arg);
    }

    private static function run($arg){
        $result = $arg;
        foreach (self::$functions as $function) {
            $result = $function($result);
        }
        return $result;
    }
}

echo Pipeline::make(
    function($var) { return $var * 3; },
    function($var) { return $var + 1; },
    function($var) { return $var / 2; }
)(3); //  5