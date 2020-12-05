<?php

namespace DevNax\Help\Admin;
use DevNax\Help\Views as Views;
use DevNax\Help\Keys as Keys;

class Menu{
    private static $keys = null;

    static function init(){
        \add_action( 'admin_menu',  Keys::$names->admin_menu_cb);
    }


    static function menu_init(){
        \add_menu_page( 
            Keys::$names->admin_menu_title, 
            Keys::$names->admin_menu_title, 
            'manage_options', 
            Keys::$names->admin_menu_slug, 
            Keys::$names->admin_menu_page_cb, 
            Keys::$names->admin_menu_icon, 
            80 );
    }


    static function menu_page(){
        Views::load('admin/page');
    }

}