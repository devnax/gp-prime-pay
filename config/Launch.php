<?php
namespace DevNax\Help;
use DevNax\Help\Keys as Keys;

class Launch{
    
    static function run(){
       
        // load for admin
        if(is_admin()){
            call_user_func(Keys::$names->plugin_admin_init );
            \NXLAdmin\Admin::init();
            return;
        }

        // fronend 
        call_user_func(Keys::$names->plugin_frontend_init);
    }
}