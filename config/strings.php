<?php


return [
        
    // Config Callbacks
    "plugin_action_link"        => "DevNax\Help\ActionLinks::links",
    "plugin_active"             => "DevNax\Help\Active::run",
    "plugin_deactive"           => "DevNax\Help\Deactive::run",
    "plugin_uninstall"          => "DevNax\Help\Uninstall::run",
    "plugin_launch"             => "DevNax\Help\Launch::run",
    "plugin_admin_init"         => "DevNax\Help\Admin::init",
    "plugin_frontend_init"      => "DevNax\Help\Frontend::init",

    // Admin Keys
    "admin_enqueue_scripts"     => "DevNax\Help\Admin::Scripts",
    "admin_menu_title"          => "Site Help",
    "admin_menu_slug"           => "site-Help",
    "admin_menu_icon"           => "Site Help",
    "admin_menu_cb"             => "DevNax\Help\Admin\Menu::menu_init",
    "admin_menu_page_cb"        => "DevNax\Help\Admin\Menu::menu_page",


    // Front Scripts
    "front_enqueue"         => "DevNax\Help\Frontend::load_scripts",
    "front_ajax_handler"    => "DevNax\Help\Frontend\AjaxHandler::init",
    "check_scripts"         => "DevNax\Help\Frontend::check_scripts",
    "front_scripts"         => [
        "Help" => [
            'src'       => '/js/Help.front.min.js',
            'footer'    => true,
            'dep'       => []
        ],
        // "Help.css" => [
        //     'src'       => NXP_ASSETS_URI.'/css/Help.front.min.css',
        //     'footer'    => false,
        //     'dep'       => []
        // ],
    ]
];