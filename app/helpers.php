<?php

use Illuminate\Support\Facades\DB;

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

if(!function_exists('btnHal')) {
    function btnHal($whereId, $id_user) {
        return DB::table('permission_perpage as a')
                    ->join('permission_button_gudang as b', 'b.id_permission_button', 'a.id_permission_button')
                    ->where([['a.id_permission_button', $whereId], ['a.id_user', $id_user]])
                    ->first();
    }
}

if(!function_exists('btnSetHal')) {
    function btnSetHal($halaman, $id_user, $jenis) {
        return DB::select("SELECT a.*, b.id_permission_page FROM permission_button_gudang AS
        a
        LEFT JOIN (
        SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
        WHERE b.id_user ='$id_user'
        ) AS b ON b.id_permission_button = a.id_permission_button
        WHERE a.jenis = '$jenis' AND a.id_permission_gudang = '$halaman'");
    }
}