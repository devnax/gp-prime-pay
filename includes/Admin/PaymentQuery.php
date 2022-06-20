<?php

namespace Devnax\GPPrime\Admin;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Views as Views;


class PaymentQuery{
   
   static function init(){
      \add_action( 'admin_menu', 'Devnax\GPPrime\Admin\PaymentQuery::menu_init');
   }
   
   
   
   static function menu_init(){
      add_submenu_page(
         'edit.php?post_type='.Transection::$type,
         "Payment Query",
         "Payment Querys",
         'manage_options',
         'payment-query',
         'Devnax\GPPrime\Admin\PaymentQuery::menu_page'
      );
   }
   
   static function menu_page(){
      $settings = Settings::get();
      Views::load('Admin/PaymentQuery', $settings);
   }
}