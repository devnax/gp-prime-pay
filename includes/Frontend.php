<?php

namespace Devnax\GPPrime;
use Devnax\GPPrime\Keys as Keys;
use Devnax\GPPrime\Shortcodes\PayButton as PayButton;
use Devnax\GPPrime\Frontend\AjaxHandler as AjaxHandler;
use Devnax\GPPrime\Admin\Settings as Settings;


class Frontend{

    

    static function init(){
        PayButton::init();
        AjaxHandler::init();
        // start the front query
        add_action('wp_enqueue_scripts', Keys::$names->front_enqueue);
        //add_filter('wp_enqueue_scripts',Keys::$names->front_enqueue,10,3);
    }

    
    static function load_scripts(){
        
        foreach(Keys::$names->front_scripts as $keys => $scripts){
            $ext = \explode('.', $scripts['src']);
            
            if(end($ext) == 'js'){
                wp_enqueue_script( $keys, $scripts['src'], $scripts['dep'], GP_PRIME_SCRIPT_VERSION, $scripts['footer'] );
            }else{
                wp_enqueue_style( $keys, $scripts['src'], $scripts['dep'], GP_PRIME_SCRIPT_VERSION, $scripts['footer'] );
            }
        }

        wp_enqueue_script('jquery');

        $vars = [];
        $settings = Settings::get();
        
        $vars['ajaxurl']  = admin_url('admin-ajax.php');
        $vars['site_url'] = site_url();
        $vars['endpoinds'] = GP_PRIME_END_POINTS;
        if($settings){
            $vars['public_key'] = $settings['public_key'];
        }

        wp_localize_script( 'jquery', 'GP_PRIME', $vars );
    }


   
    static function check_scripts($src){
        //pre($src);
        
    }


}