<?php
namespace Devnax\GPPrime\Admin;
use Devnax\GPPrime\Views as Views;


class Transection{

   static $type = 'gpprime_transection';

   static function init(){
      \add_action( 'init',  "Devnax\GPPrime\Admin\Transection::register");
      \add_filter('manage_'.self::$type.'_posts_columns', "Devnax\GPPrime\Admin\Transection::columns");
      \add_action('manage_'.self::$type.'_posts_custom_column', "Devnax\GPPrime\Admin\Transection::manage_columns", 10, 2);
   }


   static function getMsg($code){
      $msg = [
         "00" =>	"Success	Payment Completed",
         "01" =>	"Refer to Card Issuer",
         "03" =>	"Invalid Merchant ID",
         "05" =>	"Do Not Honour",
         "12" =>	"Invalid Transaction",
         "13" =>	"Invalid Amount",
         "14" =>	"Invalid Card Number	",
         "17" =>	"Customer Cancellation",
         "19" =>	"Re-enter Transaction ",
         "30" =>	"Format Error",
         "41" =>	"Lost Card Pick Up",
         "43" =>	"Stolen Card -Pick Up",
         "50" =>	"Invalid Payment Condition",
         "51" =>	"Insufficient Funds	Not enough credit limit to pay. ",
         "54" =>	"Expired Card",
         "55" =>	"Wrong Pin",
         "58" =>	"Transaction not Permitted to Terminal",
         "68" =>	"Response Received Too Late",
         "91" =>	"Issuer or Switch is Inoperative",
         "94" =>	"Duplicate Transmission	",
         "96" =>	"System Malfunction",
         "xx" =>	"Transaction Timeout",
      ];

      if(isset($msg[$code])){
         return $msg[$code];
      }
   }


   static function enrollProcess(){

      if(!isset($_POST['referenceNo'])){
         return;
      }
      die;

      $referenceId = $_POST['referenceNo'];
      $gbpReferenceNo = $_POST['gbpReferenceNo'];

      $transection = get_post($referenceId);
      if(!$transection){
         return;
      }
      $transection_meta = get_post_meta( $referenceId, 'transection_info', true );

      $author        = $transection->post_author;
      $wp_user       = get_user_by('id', $author);
      $user          = $wp_user->data;
      $course_id     = $transection_meta['course_id']; 
      $course        = get_post( $course_id );
      $permalink     = get_permalink($course_id);
      $amount        = $transection_meta['amount'];

      if($course->post_type === 'groups'){
         $courses = learndash_get_group_courses_list($course_id);
         if($courses){
            foreach( $courses as $courseId){
               ld_update_course_access( $user->ID, $courseId );
            }
         }
      }else{
         ld_update_course_access( $user->ID, $course_id );
      }

      $prevMeta = get_post_meta( $referenceId, 'transection_info', true );
      update_post_meta( $referenceId, 'transection_info', array_merge($prevMeta, ['gbpReferenceNo' => $gbpReferenceNo]));
      
      ob_start();
         Views::load('Frontend/invoice', [
            'user_nicename' => $user->display_name,
            'user_email' => $user->user_email,
            'amount' => $amount,
            'permalink' => $permalink,
            'invoiceId' => $referenceId,
            'course_title' => $course->post_title
         ]);
      $content   = ob_get_clean();
      $headers   = [];
      $headers[] = 'From: Pie Academy <contact@houseofgriffin.com>';
      $headers[] = 'MIME-Version: 1.0'; // note you can just use a simple email address
      $headers[] = 'Content-type:text/html;charset=UTF-8'; // note you can just use a simple email address
      
      // wp_mail( $user->user_email, 'House of Griffin Online Courses', $content, $headers );
      // wp_mail( 'contact@houseofgriffin.com', 'New Student Enrolled- Gouse Of Griffin', $content, $headers );
      // wp_mail( 'help@piebd.com', 'New Student Enrolled- Gouse Of Griffin ', $content, $headers );
      
      // wp_redirect( $permalink );
      // wp_die();
   }

   static function create($data){
      $id = wp_insert_post([
         'post_title' => $data['course_title'],
         'post_author' => $data['author'],
         'post_status' => 'private',
         'post_type' => self::$type
      ]);

      add_post_meta( $id, 'transection_info', [
         'amount' => $data['amount'],
         'course_id' => $data['course_id'],
      ], true );

      return $id;
   }

   
   // static function create($data){
   //    $id = wp_insert_post([
   //       'post_title' => $data['course_title'],
   //       'post_author' => $data['author'],
   //       'post_status' => 'private',
   //       'post_type' => self::$type
   //    ]);

   //    add_post_meta( $id, 'transection_info', [
   //       'amount' => $data['amount'],
   //       'course_id' => $data['course_id'],
   //       'gbpReferenceNo' => $data['gbpReferenceNo'],
   //       'referenceNo' => $data['referenceNo']
   //    ], true );
   // }

   static function register(){
        $labels = array(
            'name'                  => 'All Transections',
            'singular_name'         => 'Transection',
            'menu_name'             => 'GP Prime Pay',
            'name_admin_bar'        => 'GP Prime Pay',
            'add_new'               => 'Add New',
            'new_item'              => 'New Transection',
            'edit_item'             => 'Edit Transection',
            'view_item'             => 'View Transection',
            'all_items'             => 'All Transections',
            'search_items'          => 'Search Transections'
        );
    
    
        $capabilities = array(
            'publish_'.self::$type          => 'publish_'.self::$type,
            'edit_'.self::$type             => 'edit_'.self::$type,
            'edit_others_'.self::$type      => 'edit_others_'.self::$type,
            'delete_'.self::$type           => 'delete_'.self::$type,
            'delete_others_'.self::$type    => 'delete_others_'.self::$type,
            'read_private_'.self::$type     => 'read_private_'.self::$type,
            'edit_'.self::$type             => 'edit_'.self::$type,
            'delete_'.self::$type           => 'delete_'.self::$type,
            'read_'.self::$type             => 'read_'.self::$type,
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => self::$type ),
            // 'capability_type'    => $type,
            'capabilities'       => $capabilities,
            'map_meta_cap'       => true,
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 20,
            'supports'           => array( 'title'),
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-money-alt'
        );
    
        register_post_type( self::$type, $args );
   }

   static function columns($columns){
      return [
         'cb' => '<input type="checkbox" />',
         "title" => "Course Name",
         "author" => "User",
         "referenceNo" => "Referance Number",
         "gbpReferenceNo" => "GP Reference",
         "amount" => "Amount",
         "date" => "Date"
      ];
   }


   static function manage_columns($column_key, $post_id){
      $meta = get_post_meta( $post_id, 'transection_info', true);
      if(!$meta){
         return;
      }
      if ($column_key == 'referenceNo') {
         echo $meta['referenceNo'];
      }elseif ($column_key == 'gbpReferenceNo') {
         echo $meta['gbpReferenceNo'];
      }elseif ($column_key == 'amount') {
         echo "฿".$meta['amount'];
      }
   }
}