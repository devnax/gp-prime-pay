<?php


return [
        
    // Config Callbacks
    "plugin_action_link"        => "Devnax\GPPrime\ActionLinks::links",
    "plugin_active"             => "Devnax\GPPrime\Active::run",
    "plugin_deactive"           => "Devnax\GPPrime\Deactive::run",
    "plugin_uninstall"          => "Devnax\GPPrime\Uninstall::run",
    "plugin_launch"             => "Devnax\GPPrime\Launch::run",
    "plugin_admin_init"         => "Devnax\GPPrime\Admin::init",
    "plugin_frontend_init"      => "Devnax\GPPrime\Frontend::init",

    // Admin Keys
    "admin_enqueue_scripts"     => "Devnax\GPPrime\Admin::Scripts",

    // Front Scripts
    "front_enqueue"         => "Devnax\GPPrime\Frontend::load_scripts",
    "check_scripts"         => "Devnax\GPPrime\Frontend::check_scripts",
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