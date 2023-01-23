<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Buku_besar extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-t');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $buku = DB::select("SELECT  a.kd_gabungan, a.id_akun, b.no_akun, b.nm_akun, sum(a.debit) as debit, sum(a.kredit) as kredit
        FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.tgl BETWEEN '$tgl1' and '$tgl2' and a.id_lokasi = '1'
        group by a.id_akun
        order by b.no_akun ASC
        ");
        $data = [
            'title' => 'Buku Besar',
            'buku' => $buku,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];
        return view('buku.index', $data);
    }

    public function detail_buku(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $id_akun = $r->id_akun;

        $buku = DB::select("SELECT  a.kd_gabungan, a.id_akun, b.no_akun, b.nm_akun, sum(a.debit) as debit, sum(a.kredit) as kredit
        FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.tgl BETWEEN '$tgl1' and '$tgl2' and a.id_lokasi = '1' and a.id_akun = '$id_akun'
        group by a.id_akun
        order by b.no_akun ASC
        ");

        $akun = DB::table("tb_akun")->where('id_akun', $id_akun)->first();

        $data = [
            'title' => 'Detail Buku Besar',
            'buku' => $buku,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'akun' => $akun
        ];
        return view('buku.detail', $data);
    }
}
