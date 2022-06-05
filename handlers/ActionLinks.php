<?php

namespace Devnax\GPPrime;


class ActionLinks{
    static function links($links){

        $links = array_merge( array(
            '<a href="' . esc_url( admin_url( '/admin.php?page=') ) . '">' . __( 'Settings', GP_PRIME_TXTDOMAIN ) . '</a>'
        ), $links );

        return $links;
    }
}