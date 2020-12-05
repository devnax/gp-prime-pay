<?php
namespace DevNax\Help;
use DevNax\Help\Keys as Keys;

class Lounch{
    
    static function run(){
       
        // load for admin
        if(is_admin()){
            call_user_func(Keys::$names->admin_init_cb );
            \NXLAdmin\Admin::init();
            return;
        }

        // fronend 
        call_user_func(Keys::$names->frontend_init_cb);
    }
}