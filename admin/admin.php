<?php

namespace NXLAdmin;



class Admin{


    static function init(){
         // Loading the Admin scripts
         add_action( 'admin_enqueue_scripts', ["\NXLAdmin\Admin", "loadScripts"] );
         add_action( 'admin_footer', ["\NXLAdmin\Admin", "adminFooter"] );
        Menu::init();
        UserProfileField::init();
    }

    static function loadScripts(){
        
        if(isset($_GET['page']) && $_GET['page'] === 'nx-login'){
            // Load Admin Resource
        }
    }


    static function adminFooter(){
        
    }
}