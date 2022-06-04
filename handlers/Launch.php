<?php
namespace Devnax\GPPrime;
use Devnax\GPPrime\Keys as Keys;

class Launch{
    
    static function run(){
        call_user_func(Keys::$names->plugin_admin_init);
        call_user_func(Keys::$names->plugin_frontend_init);
    }
}