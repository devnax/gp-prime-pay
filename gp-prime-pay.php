<?php

/**
 * Plugin Name: GP Prime Pay
 * Description: A Plugin For starter Wordpress
 * Plugin URI:  https://site.com
 * Version:     1.0.0
 * Author:      Naxrul Ahmed
 * Author URI:  https://fb.com/devnax
 * License:     GPL2
 * Text Domain: gp-prime-pay
 * Domain Path: /languages
 */


if ( ! defined( 'ABSPATH' )) {
	exit; // Exit if accessed directly.
}


/**
 * Load the autoloader
 */
include __DIR__.'/vendor/autoload.php';

use Devnax\GPPrime\Keys as Keys;


final class WpStarter{

    const PREFIX         = "NXH";

    /**
     * initial the Plugin
     */
    static function init(){
        if(defined("NXH_INIT")){
            return;
        }
        Keys::init();
        self::consts();
        self::actions();

    }

    

    /**
     * Plugin Constans
     */
    private static function consts(){
        define('NXH_INIT', true );
        define('NXH_VERSION', '1.1.0' );
        define('NXH_SCRIPT_VERSION', rand() );
        define('NXH_TXTDOMAIN', 'nx-login' );
        define('NXH_DIR', __DIR__ );
        define('NXH_URL', plugin_dir_url( __FILE__ ) );
        define('NXH_ADMIN_URI', NXH_INIT.'/admin' );
        define('NXH_ADMIN_DIR', NXH_DIR.'/admin' );
        define('NXH_FRONTEND_DIR', NXH_DIR.'/frontend' );
        define('NXH_FRONTEND_URI', NXH_INIT.'/frontend' );
    }



    /**
     * Global Actions
     */
    private static function actions(){
        

        /**
         * Loaded hook
         */
        add_action( 'plugins_loaded',  Keys::$names->plugin_launch);

        /**
         * Adding action links
         */
        add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), Keys::$names->plugin_action_link );

        /*
		 * Activation Plugin Hook
		 */
		register_activation_hook( __FILE__, Keys::$names->plugin_active );

		/*
		 * Uninstall Plugin Hook
		 */
		register_deactivation_hook( __FILE__, Keys::$names->plugin_deactive );

		/*
		 * Uninstall Plugin Hook
		 */
		register_uninstall_hook( __FILE__, Keys::$names->plugin_uninstall );
    }


}




/**
 * Start the plugin 
 */
WpStarter::init();

