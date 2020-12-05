<?php

namespace DevNax\Help;



class Frontend{

    

    static function init(){
        
    }

    
    static function loadScripts(){
        if(!self::isPrintable()){
           return;
        }
        wp_enqueue_style( 'style', NXL_FRONTEND_URI.'/assets/css/style.css', null, NXL_SCRIPT_VERSION );
        wp_enqueue_script( 'script', NXL_FRONTEND_URI.'/assets/js/script.js', ['jquery'], NXL_SCRIPT_VERSION, true );
        
       

        $vars = [];
        
        $vars['ajaxurl']  = admin_url('admin-ajax.php');
        $vars['home_url'] = home_url();

        wp_localize_script( 'script', 'NXL_SETTING', $vars );
    }


}