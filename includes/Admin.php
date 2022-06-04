<?php

namespace Devnax\GPPrime;
use Devnax\GPPrime\Keys as Keys;


class Admin{

    static function init(){
        // Loading the Admin scripts
        add_action( 'admin_enqueue_scripts', Keys::$names->admin_enqueue_scripts );
        Admin\Menu::init();
    }

    static function Scripts(){
        
    }
}