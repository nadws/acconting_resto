<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Jurnal_pemasukan extends Controller
{
    public function index(Request $r)
    {
        $id_lokasi = 1;
        $tgl1 = $r->dari ?? date('Y-m-1');
        $tgl2 = $r->sampai ?? date('Y-m-d');
        $data = [
            'title' => 'Jurnal Pemasukan',
            'jurnal' => DB::table('tb_jurnal as a')->join('tb_akun_fix as b', 'a.id_akun', 'b.id_akun')
                        ->where([['a.id_buku',1],['a.id_lokasi', $id_lokasi]])
                        ->whereBetween('a.tgl', [$tgl1, $tgl2])->orderBy('a.id_jurnal', 'DESC')
                        ->get()
        ];
        return view('jurnal_pemasukan.index', $data);
    }

    public function data_pemasukan(Request $r)
    {
        $id_lokasi = '1';
        $tglDari = $r->dari;
        $tglSampai = $r->sampai;
        if (empty($tglDari)) {
            $dari = date('Y-m-1');
            $sampai = date('Y-m-d');
        } else {
            $dari = $tglDari;
            $sampai = $tglSampai;
        }

        return DataTables::of(Jurnal::join('tb_akun_fix', 'tb_akun.id_akun', '=', 'tb_jurnal.id_akun')->where([
            ['id_buku', 1],
            ['tb_jurnal.id_lokasi', $id_lokasi]
        ])->whereBetween('tgl', [$dari, $sampai])->orderBy('tb_jurnal.id_jurnal', 'DESC')->get())->toJson();
    }
}
