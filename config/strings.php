<?php


return [
        
    // Config Callbacks
    "action_link_cb"            => "DevNax\Help\ActionLinks::links",
    "active_cb"                 => "DevNax\Help\Active::run",
    "deactive_cb"               => "DevNax\Help\Deactive::run",
    "uninstall_cb"              => "DevNax\Help\Uninstall::run",
    "lounch_cb"                 => "DevNax\Help\Lounch::run",
    "admin_init_cb"             => "DevNax\Help\Admin::init",
    "frontend_init_cb"          => "DevNax\Help\Frontend::init",

    // Admin Keys
    "admin_enqueue_scripts"     => "DevNax\Help\Admin::Scripts",
    "admin_menu_title"          => "Site Help",
    "admin_menu_slug"           => "site-help",
    "admin_menu_icon"           => "Site Help",
    "admin_menu_cb"             => "DevNax\Help\Admin\Menu::menu_init",
    "admin_menu_page_cb"        => "DevNax\Help\Admin\Menu::menu_page",
];