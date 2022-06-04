<?php
namespace DevNax\Help;

// Keys::$names->callback_cb
class Keys{

    static $names        = false;
    private $KEY_TREE    = '';

    static function init(){
        if(!self::$names){
            $keys = include __DIR__.'/strings.php';
            self::$names = new self;
            self::$names->KEY_TREE = $keys;
        }
        return self::$names;
    }

    function __get($name){
        return isset($this->KEY_TREE[$name]) ? $this->KEY_TREE[$name] : "No Key";
    }
}
