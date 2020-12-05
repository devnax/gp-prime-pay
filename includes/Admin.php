<?php

namespace DevNax\Help;
use DevNax\Help\Keys as Keys;


class Admin{


    static function init(){
        // Loading the Admin scripts
        add_action( 'admin_enqueue_scripts', Keys::$names->admin_enqueue_scripts );
        Admin\Menu::init();
    }

    static function Scripts(){
        
    }


    static function adminFooter(){
        
    }
}