<?php

namespace Devnax\GPPrime;
use Devnax\GPPrime\Keys as Keys;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\PaymentQuery as PaymentQuery;

class Admin{

    static function init(){
        // Loading the Admin scripts
        add_action( 'admin_enqueue_scripts', Keys::$names->admin_enqueue_scripts );
        Transection::init();
        PaymentQuery::init();
        Settings::init();
    }

    static function load_scripts(){
        foreach(Keys::$names->admin_scripts as $keys => $scripts){
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
            $vars['secret_key'] = $settings['secret_key'];
        }

        wp_localize_script( 'jquery', 'GP_PRIME', $vars );
    }
}