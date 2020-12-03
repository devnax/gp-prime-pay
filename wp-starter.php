<?php

/**
 * Plugin Name: WP Starter
 * Description: A Plugin For starter Wordpress
 * Plugin URI:  https://site.com
 * Version:     1.0.0
 * Author:      Naxrul Ahmed
 * Author URI:  https://site.com
 * License:     GPL2
 * Text Domain: wp-starter
 * Domain Path: /languages
 */


if ( ! defined( 'ABSPATH' )) {
	exit; // Exit if accessed directly.
}


/**
 * Load the autoloader
 */
include __DIR__.'/vendor/autoload.php';




final class NXLogin{


    /**
     * initial the Plugin
     */
    static function init(){
        if(defined("NXL_INIT")){
            return;
        }
        self::consts();
        self::actions();

    }

    

    /**
     * Plugin Constans
     */
    private static function consts(){
        define('NXL_INIT', true );
        define('NXL_VERSION', '1.1.0' );
        define('NXL_SCRIPT_VERSION', rand() );
        define('NXL_TXTDOMAIN', 'nx-login' );
        define('NXL_DIR', __DIR__ );
        define('NXL_URL', plugin_dir_url( __FILE__ ) );
        define('NXL_ADMIN_URI', NXL_URL.'/admin' );
        define('NXL_ADMIN_DIR', NXL_DIR.'/admin' );
        define('NXL_FRONTEND_DIR', NXL_DIR.'/frontend' );
        define('NXL_FRONTEND_URI', NXL_URL.'/frontend' );
    }



    /**
     * Global Actions
     */
    private static function actions(){
        

        /**
         * Loaded hook
         */
        add_action( 'plugins_loaded', "NXLogin::loaded" );

        /**
         * Adding action links
         */
        add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), '\NXLConfig\ActionLinks::links' );

        /*
		 * Activation Plugin Hook
		 */
		register_activation_hook( __FILE__, '\NXLConfig\Active::run' );

		/*
		 * Uninstall Plugin Hook
		 */
		register_deactivation_hook( __FILE__, '\NXLConfig\Deactive::run' );

		/*
		 * Uninstall Plugin Hook
		 */
		register_uninstall_hook( __FILE__, '\NXLConfig\Uninstall::run' );
    }




    /**
     * Load all files here
     */
    static function loaded(){
        

        // load for admin
        if(is_admin()){
            \NXLAdmin\Admin::init();
            return;
        }

        // fronend 
        \NXLFrontend\Frontend::init();

        
    }

}




/**
 * Start the plugin 
 */
NXLogin::init();

