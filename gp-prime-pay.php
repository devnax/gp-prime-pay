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

use Devnax\GPPrime\Admin\Settings as Settings;


/**
 * Load the autoloader
 */
include __DIR__.'/vendor/autoload.php';

use Devnax\GPPrime\Keys as Keys;


final class GBPrimPayRoot{

    /**
     * initial the Plugin
     */
    static function init(){
        self::consts();
        Keys::init();
        self::actions();
    }

    

    /**
     * Plugin Constans
     */
    private static function consts(){
        define('GP_PRIME_INIT', true );
        define('GP_PRIME_VERSION', '1.1.0' );
        define('GP_PRIME_SCRIPT_VERSION', rand() );
        define('GP_PRIME_TXTDOMAIN', 'nx-login' );
        define('GP_PRIME_DIR', __DIR__ );
        define('GP_PRIME_URL', plugin_dir_url( __FILE__ ) );
        define('GP_PRIME_ADMIN_URI', GP_PRIME_URL.'/admin' );
        define('GP_PRIME_ADMIN_DIR', GP_PRIME_DIR.'/admin' );
        define('GP_PRIME_FRONTEND_DIR', GP_PRIME_DIR.'/frontend' );
        define('GP_PRIME_FRONTEND_URI', GP_PRIME_URL.'/frontend' );
        define('GP_PRIME_ASSET_URI', GP_PRIME_URL.'/assets' );

        // GP Prime
        $settings = Settings::get();
        $apiUrl = 'api.globalprimepay.com';
        if(!$settings['test_mode']){
            $apiUrl = 'api.gbprimepay.com';
        }

        define('GP_PRIME_END_POINTS', [
            'query' => "https://$apiUrl/v1/check_status_txn",
            'tokens' => "https://$apiUrl/v2/tokens",
            'charge' => "https://$apiUrl/v2/tokens/charge",
            'secure' => "https://$apiUrl/v2/tokens/3d_secured"
        ]);
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
GBPrimPayRoot::init();

