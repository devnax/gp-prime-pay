<?php
namespace Devnax\GPPrime\Shortcodes;
use Devnax\GPPrime\Views as Views;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\Transection as Transection;

class PayButton{
   static function init(){
     add_shortcode('gp_pay_button', 'Devnax\GPPrime\Shortcodes\PayButton::template');
   }
   

   static function template($atts){
      $atts = shortcode_atts( [
         'amount' => 0,
         'currency' => "฿",
         'button_text' => "Pay Now",
         'id' => 'gp_pay_button'
      ], $atts);
      $settings = Settings::get();
      $status = '';
      $message = '';


      if(isset($_POST['referenceNo'])){
         $referenceNo = $_POST['referenceNo'];
         $resultCode = $_POST['resultCode'];
         if($resultCode === '00'){
            $transection = Transection::enrollProcess();
            $status = 'success';
         }else{
            wp_delete_post( $referenceNo );
            $status = 'faild';
         }

         $message = Transection::getMsg($resultCode);
      }

      ob_start();

      if(!$settings){
         echo 'Public Key Not Found';
      }else{
         Views::load('Shortcodes/PayButton', array_merge($atts, $settings, [
            'status' => $status,
            'message' => $message
         ]));
      }
      return ob_get_clean();
   }
}

