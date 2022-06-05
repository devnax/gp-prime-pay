<?php

namespace Devnax\GPPrime\Admin;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Views as Views;


class Settings{
   
   static function init(){
      \add_action( 'admin_menu', 'Devnax\GPPrime\Admin\Settings::menu_init');
   }
   
   static function get(){
      return get_option('gp_prime_settings');
   }
   
   static function set($data){
      $get  = self::get();
      if($get){
         update_option( 'gp_prime_settings', $data );
      }else{
         add_option( 'gp_prime_settings', $data);
      }
   }
   
   static function menu_init(){
      add_submenu_page(
         'edit.php?post_type='.Transection::$type,
         "Settings",
         "Settings",
         'manage_options',
         'settings',
         'Devnax\GPPrime\Admin\Settings::menu_page'
      );
   }
   
   static function menu_page(){
      
      $public_key  = null;
      $secret_key = null;
      
      $settings = self::get();
      if($settings){
         $public_key  = $settings['public_key'];
         $secret_key  = $settings['secret_key'];
      }
      
      if(isset($_POST['gp_settings_submit'])){
         $public_key = $_POST['public_key'];
         $secret_key = $_POST['secret_key'];
         self::set([
            'public_key' => $public_key,
            'secret_key' => $secret_key
         ]);
      }
      
      Views::load('Admin/Settings', [
         'public_key' => $public_key,
         'secret_key' => $secret_key
      ]);
   }
}