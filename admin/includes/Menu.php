<?php

namespace NXLAdmin;

class Menu{



    static function init(){
        \add_action( 'admin_menu',  ['\NXLAdmin\Menu','adminMenuPages']);
    }


    static function adminMenuPages(){
        \add_menu_page( "NX Login", 'NX Login', 'manage_options', self::PAGE_SLUG, ['\NXLAdmin\Menu','menuPage'], NXL_ADMIN_URI.'/assets/img/admin-icon.png', 80 );
    }


    static function menuPage(){

        include NXL_ADMIN_DIR.'/views/admin-page.php';
    }

}