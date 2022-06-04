<?php

namespace DevNax\Help;


class ActionLinks{
    static function links($links){

        $links = array_merge( array(
            '<a href="' . esc_url( admin_url( '/admin.php?page=') ) . '">' . __( 'Settings', NXH_TXTDOMAIN ) . '</a>'
        ), $links );

        return $links;
    }
}