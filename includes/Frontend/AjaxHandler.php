<?php

namespace Devnax\GPPrime\Frontend;
use Devnax\GPPrime\GPPrimeRequest as GPPrimeRequest;
use Devnax\GPPrime\Admin\Settings as Settings;
use Devnax\GPPrime\Admin\Transection as Transection;
use Devnax\GPPrime\Views as Views;

class AjaxHandler{
   static function init(){
      add_action( 'wp_ajax_gp_prime_pay', 'Devnax\GPPrime\Frontend\AjaxHandler::pay' );
      add_action( 'wp_ajax_nopriv_gp_prime_pay', 'Devnax\GPPrime\Frontend\AjaxHandler::pay');
   }
   
   static function pay(){

      if(!isset($_POST['token'])){
         wp_send_json( [
            "status" => "error",
            "message" => "Token Not Found!"
         ], 401);
         wp_die();
      }


      $settings = Settings::get();
      if(!$settings){
         wp_send_json( [
            "status" => "error",
            "message" => "Settings Not Found!"
         ], 401);
         wp_die();
      }
      $token = $_POST['token'];
      $wp_user    = wp_get_current_user();
      $user    = $wp_user->data;
      $permalink     = wp_get_referer();
      $course_id = url_to_postid( $permalink ); 
      $course    = get_post( $course_id );
      $lds_info = get_post_meta( $course_id, '_sfwd-courses', true );
      $amount = $lds_info['sfwd-courses_course_price'];
      $secret_key = $settings['secret_key'];

      $referenceId = Transection::create([
         'course_title' => $course->post_title,
         'author' => $user->ID,
         'customerName' => $user->display_name,
         'amount' => $amount,
         'course_id' => $course_id
      ]);


      $data = array(
         'amount' => $amount,
         'referenceNo' => $referenceId,
         'detail' => $course->post_title,
         'customerName' => $user->display_name,
         'customerEmail' => $user->user_email,
         'merchantDefined1' => $user->ID,
         'card' => array(
            'token' => $token,
         ),
         'otp' => 'Y',
         'backgroundUrl' => $permalink,
         'responseUrl' => $permalink
      );
      
      
      $payload = json_encode($data);
      
      $ch = curl_init(GP_PRIME_END_POINTS['charge']);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json',
         'Content-Length: ' . strlen($payload))
      );
      
      $result = curl_exec($ch);
      
      curl_close($ch);
      
      $response = json_decode($result, true);

      if($response['resultCode'] !== '00'){
         wp_send_json( [
            "status" => "error",
            "message" => $response['resultMessage']
         ], 401);
         wp_die();
      }

      wp_send_json([
         'status' => "success",
         'message' => "Payment Success",
         'gbpReferenceNo' => $response['gbpReferenceNo'],
         'referenceNo' => $response['referenceNo']
      ]);
      wp_die();
   }
}
