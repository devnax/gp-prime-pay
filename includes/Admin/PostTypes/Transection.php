<?php
namespace Devnax\GPPrime\Admin\PostTypes;


class Transection{

   static $type = 'gpprime_transection';

   static function init(){
      \add_action( 'init',  "Devnax\GPPrime\Admin\PostTypes\Transection::register");
      \add_filter('manage_'.self::$type.'_posts_columns', "Devnax\GPPrime\Admin\PostTypes\Transection::columns");
      \add_action('manage_'.self::$type.'_posts_custom_column', "Devnax\GPPrime\Admin\PostTypes\Transection::manage_columns", 10, 2);
   }

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
         "customer_name" => "Customer Name",
         "referenceNo" => "Referance Number",
         "amount" => "Amount",
         "method" => "Payment Method",
         "author" => "Author",
         "date" => "Date"
      ];
   }


   static function manage_columns($column_key, $post_id){
      if ($column_key == 'customer_name') {
         echo "Naxrul";
      }
   }
}