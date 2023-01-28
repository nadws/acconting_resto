<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashflowController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Cashflow',
        ];
        return view('cashflow.cashflow', $data);
    }

    public function loadTabel(Request $r)
    {

        $data = [
            'title' => 'Cashflow',
            'subKategori1' => DB::table('sub_kategori_cashflow')->where('jenis',1)->orderBy('urutan', 'ASC')->get(),
            'subKategori2' => DB::table('sub_kategori_cashflow')->where('jenis',2)->orderBy('urutan', 'ASC')->get(),
            'tgl1' => $r->tgl1,
            'tgl2' => $r->tgl2,
        ];
        return view('cashflow.load_tabel', $data);
    }

    public function loadSubKategori(Request $r)
    {
        $data = [
            'subKategori' => DB::table('sub_kategori_cashflow')->where('jenis', $r->jenis)->orderBy('urutan', 'ASC')->get()
        ];
        return view('cashflow.load_sub_kategori', $data);
    }
    

    public function saveSubKategori(Request $r)
    {
        DB::table('sub_kategori_cashflow')->insert([
            'id_lokasi' => 1,
            'urutan' => $r->urutan,
            'sub_kategori' => $r->sub_kategori,
            'jenis' => $r->jenis
        ]);

    }

    public function editSubKategori(Request $r)
    {
        
        for ($i=0; $i < count($r->urutan_edit); $i++) { 
            $data = [
                'urutan' => $r->urutan_edit[$i],
                'sub_kategori' => $r->sub_kategori_edit[$i],
                'jenis' => $r->jenis_edit[$i],
                
            ];
            DB::table('sub_kategori_cashflow')->where('id', $r->id_edit[$i])->update($data);
        }
    }

    public function deleteSubKategori(Request $r)
    {
        DB::table('sub_kategori_cashflow')->where('id', $r->id)->delete();
    }

    public function loadAkunSubKategori(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun_fix as a')->join('tb_kategori_akun_fix as b', 'a.id_kategori', 'b.id_kategori')->where([['a.id_lokasi', '1']])->get(),
            'id_kategori' => $r->id_kategori,
        ];
        return view('cashflow.load_akun_sub_kategori', $data);
    }

    public function saveAkunSubKategori(Request $r)
    {
        DB::table('akun_cashflow')->where('id_sub_kategori', $r->id_kategori)->delete();
        foreach($r->id_akun as $d) {
            DB::table('akun_cashflow')->insert([
                'id_sub_kategori' => $r->id_kategori,
                'id_akun' => $d,
            ]);
        }
    }

    public function loadDetailAkun(Request $r)
    {
        $id_lokasi = 1;
        $data = [
            'akun' => DB::select("SELECT * FROM `tb_jurnal` as a
            LEFT JOIN tb_akun_fix as b ON a.id_akun = b.id_akun
            where a.kd_gabungan = '$r->kd_gabungan' AND a.id_akun != '$r->id_akun';"),
            'id_kategori' => $r->id_kategori,
            'id_akun' => $r->id_akun,
        ];
        return view('cashflow.load_detail_akun',$data);
    }
}
