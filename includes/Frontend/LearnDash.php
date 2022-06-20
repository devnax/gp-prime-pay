<?php


namespace Devnax\GPPrime\Frontend;
use Devnax\GPPrime\GPPrimeRequest as GPPrimeRequest;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Views as Views;



class LearnDash{
   static function init(){
      add_filter( 'learndash_payment_button', 'Devnax\GPPrime\Frontend\LearnDash::button', 15, 2 );
   }

   static function button($buttons, $params = 0){

      ob_start();
      echo $buttons;
      echo do_shortcode('[gp_pay_button]');
      return ob_get_clean();
   }
}