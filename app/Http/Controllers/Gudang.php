<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Gudang extends Controller
{
    public function index(Request $r)
    {

        $gudang = DB::select("SELECT a.*, b.debit, b.kredit, c.nm_lokasi, d.nm_kategori, e.nm_satuan as n,f.tgl as tgl1
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
        order by (b.debit - b.kredit) DESC");
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

    public function produk($id)
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
        where a.id_lokasi = '1' AND a.jenis = '$id'
        order by a.id_list_bahan DESC
        ");
        $data = [
            'title' => 'Bahan & Barang',
            'gudang' => $gudang,
            'id_jenis' => $id,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'merk_baha' => DB::table('tb_merk_bahan')->where('id_lokasi', '1')->get(),
            'kategori' => DB::table('tb_kategori_makanan')->where([['id_lokasi', '1'], ['jenis', $id]])->get()

        ];
        return view('gudang.produk', $data);
    }

    public function loadEditBahan(Request $r)
    {
        $data = [
            'id_list_bahan' => $r->idListBahan,
            'detail' => DB::table('tb_list_bahan')->where('id_list_bahan', $r->idListBahan)->first(),
            'satuan' => DB::table('tb_satuan')->get(),
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', '1')->get()
        ];
        return view('gudang.load_edit_bahan', $data);
    }

    public function edit_bahan(Request $r)
    {
        $data = [
            'nm_bahan' => $r->nm_bahan,
            'id_satuan' => $r->id_satuan,
            'id_kategori_makanan' => $r->id_kategori_makanan,
            'monitoring' => empty($r->monitoring) ? 'T' : $r->monitoring,
        ];
        DB::table('tb_list_bahan')->where('id_list_bahan', $r->id_list_bahan)->update($data);
        return redirect()->route("produk", $r->id_jenis)->with('sukses', 'Data berhasil di edit');
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

                // $harga = DB::selectOne("SELECT sum(a.unit_prize) as hrga, sum(a.debit) as qty FROM stok_ts as a 
                // where a.opname = 'T' and id_bahan = '$id_list_bahan[$i]' group by a.id_bahan ");

                // $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

                // if (empty($urutan->urutan)) {
                //     $no_urutan = '1001';
                // } else {
                //     $no_urutan = $urutan->urutan + 1;
                // }
                // $total_rp = ($total * -1) * ($harga->hrga / $harga->qty);

                // $data = [
                //     'tgl' => date("Y-m-d"),
                //     'id_akun' => 6,
                //     'ket' => 'Pemutihan daging & ayam',
                //     'no_nota' => 'TKM' . $no_urutan,
                //     'kredit' => $total_rp,
                //     'id_buku' => '3',
                //     'kd_gabungan' => 'TKM' . $no_urutan,
                //     'id_lokasi' => '1',
                //     'urutan' => $no_urutan,
                // ];
                // DB::table('tb_jurnal')->insert($data);

                // $data = [
                //     'tgl' => date("Y-m-d"),
                //     'id_akun' => 7,
                //     'ket' => 'Pemutihan daging & ayam',
                //     'no_nota' => 'TKM' . $no_urutan,
                //     'debit' => $total_rp,
                //     'id_buku' => '3',
                //     'kd_gabungan' => 'TKM' . $no_urutan,
                //     'id_lokasi' => '1',
                //     'urutan' => $no_urutan,
                // ];
                // DB::table('tb_jurnal')->insert($data);
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
                // $harga = DB::selectOne("SELECT sum(a.unit_prize) as hrga, sum(a.debit) as qty FROM stok_ts as a 
                // where a.opname = 'T' and  a.id_bahan = '$id_list_bahan[$i]' group by a.id_bahan ");

                // $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

                // if (empty($urutan->urutan)) {
                //     $no_urutan = '1001';
                // } else {
                //     $no_urutan = $urutan->urutan + 1;
                // }
                // $total_rp = ($total) * ($harga->hrga / $harga->qty);

                // $data = [
                //     'tgl' => date("Y-m-d"),
                //     'id_akun' => 7,
                //     'ket' => 'Pemutihan daging & ayam',
                //     'no_nota' => 'TKM' . $no_urutan,
                //     'kredit' => $total_rp,
                //     'id_buku' => '3',
                //     'kd_gabungan' => 'TKM' . $no_urutan,
                //     'id_lokasi' => '1',
                //     'urutan' => $no_urutan,
                // ];
                // DB::table('tb_jurnal')->insert($data);

                // $data = [
                //     'tgl' => date("Y-m-d"),
                //     'id_akun' => 6,
                //     'ket' => 'Pemutihan daging & ayam',
                //     'no_nota' => 'TKM' . $no_urutan,
                //     'debit' => $total_rp,
                //     'id_buku' => '3',
                //     'kd_gabungan' => 'TKM' . $no_urutan,
                //     'id_lokasi' => '1',
                //     'urutan' => $no_urutan,
                // ];
                // DB::table('tb_jurnal')->insert($data);
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
            'jenis' => $r->id_jenis,
            'tgl' => date('Y-m-d'),
        ];
        DB::table('tb_list_bahan')->insert($data);
        return redirect()->route("produk", $r->id_jenis)->with('sukses', 'Data berhasil di input');
    }

    public function hapusBahan($id, $id_jenis)
    {
        DB::table('tb_list_bahan')->where('id_list_bahan', $id)->delete();
        return redirect()->route('produk', $id_jenis)->with('sukses', 'Berhasil hapus data');
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

    public function kategoriMakanan($id)
    {
        $data = [
            'title' => 'Kategori Makanan',
            'id_jenis' => $id,
            'kat' => DB::table('tb_kategori_makanan')->where([['id_lokasi', 1], ['jenis', $id]])->get(),
        ];
        return view('gudang.kategori_makanan', $data);
    }

    public function save_kategori_makanan(Request $r)
    {
        DB::table('tb_kategori_makanan')->insert([
            'nm_kategori' => $r->nm_kategori,
            'id_lokasi' => 1,
            'jenis' => $r->id_jenis,
        ]);
        return redirect()->route('kategoriMakanan', $r->id_jenis)->with('sukses', 'Berhasil tambah kategori makanan');
    }

    public function hapus_kategori_makanan($id, $id_jenis)
    {
        DB::table('tb_kategori_makanan')->where('id_kategori_makanan', $id)->delete();
        return redirect()->route('kategoriMakanan', $id_jenis)->with('sukses', 'Berhasil hapus kategori makanan');
    }

    public function edit_kategori_makanan(Request $r)
    {
        DB::table('tb_kategori_makanan')->where('id_kategori_makanan', $r->id_kategori_makanan)->update([
            'nm_kategori' => $r->nm_kategori,
            'id_lokasi' => 1
        ]);
        return redirect()->route('kategoriMakanan', $r->id_jenis)->with('sukses', 'Berhasil edit kategori makanan');
    }
}
