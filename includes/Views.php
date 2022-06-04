<?php

namespace Devnax\GPPrime;

class Views{
    static function get($name){
        $view_dir = '';
        if(is_file("{$view_dir}/{$name}.php")){
            return "{$view_dir}/{$name}.php";
        }
        return false;
    }

    static function load($name){
       $file = self::get($name);
       if($file){
            include $file;
       }
    }
}