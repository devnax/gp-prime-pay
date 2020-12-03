<?php

namespace NXLConfig;


class ActionLinks{
    static function links($links){

        $links = array_merge( array(
            '<a href="' . esc_url( admin_url( '/admin.php?page='.\NXLAdmin\Menu::PAGE_SLUG ) ) . '">' . __( 'Settings', NXL_TXTDOMAIN ) . '</a>'
        ), $links );

        return $links;
    }
}