<?php
namespace Devnax\GPPrime\Shortcodes;
use Devnax\GPPrime\Views as Views;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\Transection as Transection;

class PayButton{
   static function init(){
     add_shortcode('gp_pay_button', 'Devnax\GPPrime\Shortcodes\PayButton::template');
     add_action( 'the_content', 'Devnax\GPPrime\Shortcodes\PayButton::process');
   }
   


   static function process($content){
      $status = '';
      $message = '';

      if(isset($_POST['referenceNo'])){
         $referenceNo = $_POST['referenceNo'];
         $resultCode = $_POST['resultCode'];
         if($resultCode === '00'){
            Transection::enrollProcess();
            $status = 'success';
         }else{
           wp_delete_post( $referenceNo );
           $status = 'faild';
         }
         $message = Transection::getMsg($resultCode);
      }

      
      if($status === 'success' || $status === 'faild'){
         $isFaild = $status === 'faild';
         $img = $isFaild ? GP_PRIME_ASSET_URI ."/img/payment-faild.png'?>" : GP_PRIME_ASSET_URI ."/img/payment-success.png'?>" ;
         ob_start();
         ?>
         <style>
            body{
               overflow: hidden;
            }
         </style>
         <div id="gp-payment-status">
            <div>
               <div>
                  <img src="<?= $img ?>" />
               </div>
               <h3><?= $message ?></h3>
               <div>
                  <button onClick='window.location.href = "<?= get_the_permalink( ) ?>"'>Close</button>
               </div>
            </div>
         </div>
         <?php
         return ob_get_clean();
      }

      return $content;
   }

   static function template($atts){
      global $post;
      $lds_info = get_post_meta( $post->ID, '_sfwd-courses', true );
      $amount = 0;
      if($lds_info){
         $amount = $lds_info['sfwd-courses_course_price'];
      }
      
      $atts = shortcode_atts( [
         'amount' => $amount,
         'currency' => "฿",
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

