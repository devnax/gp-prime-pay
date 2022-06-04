<?php

namespace Devnax\GPPrime\Admin;
use Devnax\GPPrime\Views as Views;
use Devnax\GPPrime\Keys as Keys;
use Devnax\GPPrime\Admin\PostTypes\Transection as Transection;

class Menu{
    private static $keys = null;

    static function init(){
        Transection::init();
        \add_action( 'admin_menu', 'Devnax\GPPrime\Admin\Menu::menu_init');
    }

    static function menu_init(){
        // global $submenu;
        // unset($submenu['edit.php?post_type=gpprime_transections'][10]);

        // // Hide link on listing page
        // if (isset($_GET['post_type']) && $_GET['post_type'] == 'gpprime_transections') {
        //     echo '<style type="text/css">
        //     #favorite-actions, .add-new-h2, .tablenav { display:none; }
        //     </style>';
        // }
        // \add_menu_page( 
        //     Keys::$names->admin_menu_title, 
        //     Keys::$names->admin_menu_title, 
        //     'manage_options', 
        //     Keys::$names->admin_menu_slug, 
        //     Keys::$names->admin_menu_page_cb, 
        //     Keys::$names->admin_menu_icon, 
        //     80 );
    }


    static function menu_page(){
        Views::load('admin/page');
    }

}