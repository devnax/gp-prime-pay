<?php


namespace NXLConfig;

class Active{

    static function run(){

        // add the other options for the plugin
        // install date
        $g = get_option('nxl_date');
        if(!$g){
            add_option( 'nxl_date', current_time('timestamp'));
        }
    }
}