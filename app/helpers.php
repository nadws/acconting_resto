<?php 

if(!function_exists('convert')) {
    function convert($cnv, $cnvTo, $nilai) {
        if(strtolower($cnv) == 'kg' && strtolower($cnvTo) == 'gr') {
            $hasil = $nilai * 1000;
        } else {
            $hasil = 'data salah';
        }
        return $hasil;
    }
}