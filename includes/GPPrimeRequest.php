<?php
namespace Devnax\GPPrime;
use Devnax\GPPrime\Admin\Settings as Settings;


class GPPrimeRequest{
   
   static function tokens(){
      $settings = Settings::get() or wp_die("Setting Not found!");

      $secret_key = "{secret_key}";
      
      $data = array(
         "rememberCard" => false,
         "card" => [
            "number" => "4535017710535741",
            "expirationMonth" => "05",
            "expirationYear" => "28",
            "securityCode" => "184",
            "name" => "Card Test UAT (Server Test)"
         ]
      );
      
      $payload = json_encode($data);
      
      $ch = curl_init(GP_PRIME_END_POINTS['tokens']);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json',
         'Content-Length: ' . strlen($payload)),
         "Authorization: Basic " .$settings['public_key']. ":"
      );
      
      $result = curl_exec($ch);
      curl_close($ch);
      $chargeResp = json_decode($result, true);
      wp_die($chargeResp);
   }
}