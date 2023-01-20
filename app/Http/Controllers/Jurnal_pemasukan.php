<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Jurnal_pemasukan extends Controller
{
    public function index(Request $r)
    {

        $data = [
            'title' => 'Jurnal Pemasukan',
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

        return DataTables::of(Jurnal::join('tb_akun', 'tb_akun.id_akun', '=', 'tb_jurnal.id_akun')->where([
            ['id_buku', 1],
            ['tb_jurnal.id_lokasi', $id_lokasi]
        ])->whereBetween('tgl', [$dari, $sampai])->orderBy('tb_jurnal.id_jurnal', 'DESC')->get())->toJson();
    }
}
