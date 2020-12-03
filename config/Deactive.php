<?php


namespace NXLConfig;

class Deactive{
    
    static function run(){
       
        $g      = get_option('nxl_deactivate_date');
        $date   = [current_time('timestamp')];
        if($g){
            $data = array_merge($g, $date);
        }
        add_option( 'nxl_deactivate_date', $data);
    }
}