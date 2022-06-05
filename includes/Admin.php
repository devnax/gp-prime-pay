<?php

namespace Devnax\GPPrime;
use Devnax\GPPrime\Keys as Keys;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Admin\Settings as Settings;

class Admin{

    static function init(){
        // Loading the Admin scripts
        add_action( 'admin_enqueue_scripts', Keys::$names->admin_enqueue_scripts );
        Transection::init();
        Settings::init();
    }

    static function Scripts(){
        
    }
}