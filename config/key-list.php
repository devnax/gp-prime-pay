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
        "gp-front-script" => [
            'src'       => GP_PRIME_ASSET_URI.'/js/script.js',
            'footer'    => true,
            'dep'       => []
        ],
        // "front-script" => [
        //     'src'       => GP_PRIME_ASSET_URI.'/js/GPPrime.js',
        //     'footer'    => false,
        //     'dep'       => []
        // ],
        "gp-front-css" => [
            'src'       => GP_PRIME_ASSET_URI.'/css/style.css',
            'footer'    => false,
            'dep'       => []
        ],
    ]
];