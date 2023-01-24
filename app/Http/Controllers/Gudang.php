<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Gudang extends Controller
{
    public function index(Request $r)
    {

        $gudang = DB::select("SELECT a.*, b.debit, b.kredit, c.nm_lokasi, d.nm_kategori, e.nm_satuan as n,f.tgl
        FROM tb_list_bahan as a
        LEFT join (
            SELECT b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            group by b.id_bahan
        ) as b on b.id_bahan = a.id_list_bahan
        
        left join tb_lokasi as c on c.id_lokasi = a.id_lokasi
        left join tb_kategori_makanan as d on d.id_kategori_makanan = a.id_kategori_makanan
        left join tb_satuan as e on e.id_satuan = a.id_satuan
        LEFT join (
            SELECT max(b.tgl) as tgl, b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            where b.opname ='Y'
            group by b.id_bahan
        ) as f on f.id_bahan = a.id_list_bahan
        where a.id_lokasi = '1' and a.monitoring ='Y'
        order by a.id_list_bahan DESC
        ");
        $data = [
            'title' => 'Opname Bahan',
            'gudang' => $gudang,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'merk_baha' => DB::table('tb_merk_bahan')->where('id_lokasi', '1')->get(),
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', '1')->get()

        ];
        return view('gudang.index', $data);
    }
    public function produk(Request $r)
    {

        $gudang = DB::select("SELECT a.*, b.debit, b.kredit, c.nm_lokasi, d.nm_kategori, e.nm_satuan as n,f.tgl
        FROM tb_list_bahan as a
        LEFT join (
            SELECT b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            group by b.id_bahan
        ) as b on b.id_bahan = a.id_list_bahan
        
        left join tb_lokasi as c on c.id_lokasi = a.id_lokasi
        left join tb_kategori_makanan as d on d.id_kategori_makanan = a.id_kategori_makanan
        left join tb_satuan as e on e.id_satuan = a.id_satuan
        LEFT join (
            SELECT max(b.tgl) as tgl, b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            where b.opname ='Y'
            group by b.id_bahan
        ) as f on f.id_bahan = a.id_list_bahan
        where a.id_lokasi = '1'
        order by a.id_list_bahan DESC
        ");
        $data = [
            'title' => 'Bahan',
            'gudang' => $gudang,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'merk_baha' => DB::table('tb_merk_bahan')->where('id_lokasi', '1')->get(),
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', '1')->get()

        ];
        return view('gudang.produk', $data);
    }

    public function save_opname(Request $r)
    {
        $id_list_bahan = $r->id_list_bahan;
        $stok_ak = $r->stok_ak;
        $stok_po = $r->stok_po;
        $id_satuan = $r->id_satuan;

        for ($i = 0; $i < count($id_list_bahan); $i++) {
            $stk_aktual = $stok_ak[$i];
            $stk_po = $stok_po[$i];

            $total = $stk_po - $stk_aktual;

            if ($total < 0) {
                $data = [
                    'id_bahan' => $id_list_bahan[$i],
                    'id_satuan' => $id_satuan[$i],
                    'debit' => $total * -1,
                    'tgl' => date("Y-m-d"),
                    'opname' => 'Y',
                    'kredit' => 0,
                    'no_nota' => 'Testing'
                ];
                DB::table('stok_ts')->insert($data);
            } else {
                $data = [
                    'id_bahan' => $id_list_bahan[$i],
                    'id_satuan' => $id_satuan[$i],
                    'kredit' => $total,
                    'tgl' => date("Y-m-d"),
                    'opname' => 'Y',
                    'debit' => 0,
                    'no_nota' => 'Testing'
                ];
                DB::table('stok_ts')->insert($data);
            }
        }
        return redirect()->route("gudang")->with('sukses', 'Data berhasil di input');
    }

    public function save_bahan(Request $r)
    {
        $data = [
            'nm_bahan' => $r->nm_bahan,
            'id_satuan' => $r->id_satuan,
            'id_kategori_makanan' => $r->id_kategori_makanan,
            'monitoring' => empty($r->monitoring) ? 'T' : $r->monitoring,
            'id_lokasi' => '1',
            'admin' => 'aldi',
            'tgl' => date('Y-m-d')
        ];
        DB::table('tb_list_bahan')->insert($data);
        return redirect()->route("gudang")->with('sukses', 'Data berhasil di input');
    }

    public function get_history_bahan(Request $r)
    {
        $id_list_bahan = $r->id_list_bahan;

        $bahan = DB::select("SELECT * 
        FROM stok_ts as a
        where a.id_bahan = '$id_list_bahan'");
        $data = [
            'bahan' => $bahan
        ];

        return view('gudang.history_bahan', $data);
    }

    public function merk_bahan(Request $r)
    {
        $data = [
            'title' => 'Merk Bahan',
            'merkBahan' => DB::table('tb_merk_bahan as a')
                ->join('tb_list_bahan as b', 'a.id_list_bahan', 'b.id_list_bahan')
                ->join('tb_satuan as d', 'b.id_satuan', 'd.id_satuan')
                ->join('tb_kategori_makanan as c', 'b.id_kategori_makanan', 'c.id_kategori_makanan')
                ->where('a.id_lokasi', '1')
                ->orderBy('a.id_merk_bahan', 'DESC')
                ->get(),
            'bahan' => DB::table('tb_list_bahan')->get(),
            'id_lokasi' => '1'
        ];
        return view('gudang.bahan', $data);
    }
    public function save_merk_bahan(Request $r)
    {
        $nm_bahan = $r->nm_bahan;
        $id_list_bahan = $r->id_list_bahan;
        for ($i = 0; $i < count($id_list_bahan); $i++) {
            $data = [
                'nm_merk' =>  $nm_bahan,
                'id_list_bahan' => $id_list_bahan[$i],
                'id_lokasi' => '1',
                'admin' => 'Aldi'
            ];
            DB::table('tb_merk_bahan')->insert($data);
        }
        return redirect()->route("gudang")->with('sukses', 'Data berhasil di input');
    }

    public function export_opname(Request $r)
    {
        $gudang = DB::select("SELECT a.*, b.debit, b.kredit, c.nm_lokasi, d.nm_kategori, e.nm_satuan as n,f.tgl
        FROM tb_list_bahan as a
        LEFT join (
            SELECT b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            group by b.id_bahan
        ) as b on b.id_bahan = a.id_list_bahan
        
        left join tb_lokasi as c on c.id_lokasi = a.id_lokasi
        left join tb_kategori_makanan as d on d.id_kategori_makanan = a.id_kategori_makanan
        left join tb_satuan as e on e.id_satuan = a.id_satuan
        LEFT join (
            SELECT max(b.tgl) as tgl, b.id_bahan, SUM(b.debit) as debit, sum(b.kredit) as kredit
            FROM stok_ts as b 
            where b.opname ='Y'
            group by b.id_bahan
        ) as f on f.id_bahan = a.id_list_bahan
        where a.id_lokasi = '1' and a.monitoring ='Y'
        order by a.id_list_bahan DESC
        ");
        $data = [
            'title' => 'Opname Bahan',
            'gudang' => $gudang,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'merk_baha' => DB::table('tb_merk_bahan')->where('id_lokasi', '1')->get(),
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', '1')->get()

        ];
        return view('gudang.export_opname', $data);
    }
}
