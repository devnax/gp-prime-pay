<?php

namespace Devnax\GPPrime;

class Views{
    static function get($name){
        $view_dir = GP_PRIME_DIR."/views";
        if(is_file("{$view_dir}/{$name}.php")){
            return "{$view_dir}/{$name}.php";
        }
        return false;
    }

    static function load($name, $vars = []){
       $file = self::get($name);
       try{
           extract($vars);
            include $file;
       }catch(Exception $e){
        echo $e;
       }
    }
}