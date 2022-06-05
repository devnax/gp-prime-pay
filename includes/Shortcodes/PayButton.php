<?php
namespace Devnax\GPPrime\Shortcodes;
use Devnax\GPPrime\Views as Views;
use Devnax\GPPrime\Admin\Settings as Settings;

class PayButton{
   static function init(){
     add_shortcode('gp_pay_button', 'Devnax\GPPrime\Shortcodes\PayButton::template');
   }

   static function template($atts){
      $atts = shortcode_atts( [
         'amount' => 0,
         'button_text' => "Pay Now",
         'id' => 'gp_pay_button'
      ], $atts);
      $settings = Settings::get();

      ob_start();

      if(!$settings){
         echo 'Public Key Not Found';
      }else{
         Views::load('Shortcodes/PayButton', array_merge($atts, $settings));
      }
      return ob_get_clean();
   }
}

