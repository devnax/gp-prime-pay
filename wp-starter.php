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

use DevNax\Help\Keys as Keys;


final class WpStarter{


    const PREFIX         = "NXH";
    private static $keys = null;


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
        define('NXH_ADMIN_URI', NXL_URL.'/admin' );
        define('NXH_ADMIN_DIR', NXL_DIR.'/admin' );
        define('NXH_FRONTEND_DIR', NXL_DIR.'/frontend' );
        define('NXH_FRONTEND_URI', NXL_URL.'/frontend' );
    }



    /**
     * Global Actions
     */
    private static function actions(){
        

        /**
         * Loaded hook
         */
        add_action( 'plugins_loaded',  Keys::$names->lounch_cb);

        /**
         * Adding action links
         */
        add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), Keys::$names->action_link_cb );

        /*
		 * Activation Plugin Hook
		 */
		register_activation_hook( __FILE__, Keys::$names->active_cb );

		/*
		 * Uninstall Plugin Hook
		 */
		register_deactivation_hook( __FILE__, Keys::$names->deactive_cb );

		/*
		 * Uninstall Plugin Hook
		 */
		register_uninstall_hook( __FILE__, Keys::$names->uninstall_cb );
    }


}




/**
 * Start the plugin 
 */
WpStarter::init();

