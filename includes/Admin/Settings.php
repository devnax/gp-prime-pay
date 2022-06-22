<?php

namespace Devnax\GPPrime\Admin;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Views as Views;


class Settings{
   
   static function init(){
      \add_action( 'admin_menu', 'Devnax\GPPrime\Admin\Settings::menu_init');
   }
   
   static function get(){
      $settings = get_option('gp_prime_settings');
      if($settings['test_mode']){
         $settings['public_key'] = 'zk56zPpqwzFoWPe7zkSR5zcpzQg74CjB';
         $settings['secret_key'] = 'yJJrr9irmWEgqXxKyeCGgvroj91A6DLG';
      }

      return $settings;
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
      $secret_key  = null;
      $test_mode   = null;
      
      $settings = self::get();
      if($settings){
         $public_key  = $settings['public_key'];
         $secret_key  = $settings['secret_key'];
         $test_mode   = $settings['test_mode'];
      }
      
      if(isset($_POST['gp_settings_submit'])){
         $public_key = $_POST['public_key'];
         $secret_key = $_POST['secret_key'];
         $test_mode  = $_POST['test_mode'];
         self::set([
            'public_key' => $public_key,
            'secret_key' => $secret_key,
            'test_mode' => $test_mode
         ]);
      }
      
      Views::load('Admin/Settings', [
         'public_key' => $public_key,
         'secret_key' => $secret_key,
         'test_mode' => $test_mode
      ]);
   }
}