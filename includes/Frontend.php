<?php

namespace DevNax\Help;

use DevNax\Help\Keys as Keys;


class Frontend{

    

    static function init(){
        // start the front query
        add_action('wp_enqueue_scripts', Keys::$names->front_enqueue);
        add_action('init', Keys::$names->front_ajax_handler);
        //add_filter('wp_enqueue_scripts',Keys::$names->front_enqueue,10,3);
    }

    
    static function load_scripts(){
        
        foreach(Keys::$names->front_scripts as $keys => $scripts){
            $ext = \explode('.', $scripts['src']);
            
            if(end($ext) == 'js'){
                wp_enqueue_script( $keys, $scripts['src'], $scripts['dep'], NXP_SCRIPT_VERSION, $scripts['footer'] );
            }else{
                wp_enqueue_style( $keys, $scripts['src'], $scripts['dep'], NXP_SCRIPT_VERSION, $scripts['footer'] );
            }
        }

        $vars = [];
        
        $vars['ajaxurl']  = admin_url('admin-ajax.php');
        $vars['site_url'] = site_url();

        wp_localize_script( 'pajaxy', 'NXP_SETTING', $vars );
    }


   
    static function check_scripts($src){
        //pre($src);
        
    }


}