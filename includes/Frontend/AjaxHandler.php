<?php

namespace Devnax\GPPrime\Frontend;
use Devnax\GPPrime\GPPrimeRequest as GPPrimeRequest;

class AjaxHandler{
   static function init(){
      add_action( 'wp_ajax_gp_prime_pay', 'Devnax\GPPrime\Frontend\AjaxHandler::pay' );
      add_action( 'wp_ajax_nopriv_gp_prime_pay', 'Devnax\GPPrime\Frontend\AjaxHandler::pay');
   }

   static function pay(){
      echo "Payment done";
      wp_die();
   }
}
