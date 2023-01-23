<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Jurnal_pengeluaran extends Controller
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

        $j_pengeluaran = DB::select("SELECT a.*, b.no_akun, b.nm_akun
        FROM tb_jurnal as a
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.tgl BETWEEN '$tgl1' and '$tgl2' and a.id_buku = '3'
        order by a.id_jurnal DESC
        ");
        $data = [
            'title' => 'Jurnal Pengeluaran',
            'jurnal' => $j_pengeluaran,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get()
        ];
        return view('jurnal_pengeluaran.index', $data);
    }

    public function get_isi_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();


        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', 1 == 1 ? 1 : 2]])->get(),


        ];

        if ($id == '228') {
            return view('jurnal_pengeluaran.get_isi_jurnal', $data);
        } else {
        }
    }

    public function get_satuan_bahan(Request $r)
    {
        $id_list = $r->id_list_bahan;

        $list =  DB::table('tb_list_bahan')->where('id_list_bahan', $id_list)->first();
        $d = DB::table('tb_satuan')->where('id', $list->id_satuan)->first();


        $output = [
            'id_satuan' => $d->id,
            'satuan' => $d->n
        ];

        echo json_encode($output);
    }

    public function get_merk(Request $r)
    {
        $merk = DB::table('tb_merk_bahan')->where('id_list_bahan', $r->id_list_bahan)->get();
        echo "<option>Pilih Merk</option>";
        foreach ($merk as $m) {
            echo "<option value='$m->id_merk_bahan'>$m->nm_merk</option>";
        }
    }

    public function tambah_jurnal_daging(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();


        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', 1 == 1 ? 1 : 2]])->get(),
            'count' => $r->count,
        ];

        return view('jurnal_pengeluaran.get_isi_jurnal_tambah', $data);
    }

    public function save_stok_daging(Request $r)
    {
        $tgl = $r->tgl;
        $id_akun = $r->id_akun;
        $metode = $r->metode;
        $no_id = $r->no_id;
        $keterangan = $r->keterangan;
        $total = $r->total;

        $id_list_bahan = $r->id_list_bahan;
        $id_satuan = $r->id_satuan;
        $id_merk_bahan = $r->id_merk_bahan;
        $id_satuanBeli = $r->id_satuanBeli;
        $qty = $r->qty;
        $ttl_rp = $r->ttl_rp;
        $qtyResep = $r->qtyResep;
        $t_rp = $r->t_rp;
        $ppn = $r->ppn;
        $id_akun_lain = $r->id_akun_lain;
        $debit_lain = $r->debit_lain;


        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => 'testing',
            'no_nota' => 'TSP' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TSP' . $no_urutan,
            'id_lokasi' => '1',
            'urutan' => $no_urutan,
        ];
        DB::table('tb_jurnal')->insert($data);

        for ($x = 0; $x < count($id_list_bahan); $x++) {
            $total =  $t_rp[$x] + $ppn[$x];
            $bahan =  DB::table('tb_list_bahan')->where('id_list_bahan', $id_list_bahan[$x])->first();
            $data = [
                'tgl' => $tgl,
                'id_akun' => $id_akun,
                'ket' => $keterangan,
                'ket2' => $bahan->nm_bahan,
                'no_nota' => 'TSP' . $no_urutan,
                'debit' => $total,
                'qty' => $qty[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TSP' . $no_urutan,
                'id_lokasi' => '1',
                'urutan' => $no_urutan,
                'no_urutan' => $no_id
            ];
            DB::table('tb_jurnal')->insert($data);
            $max_id = DB::selectOne("SELECT max(a.id_jurnal) as id_jurnal FROM tb_jurnal as a");



            $data = [
                'id_bahan' => $id_list_bahan[$x],
                'id_satuan' => $id_satuan[$x],
                'debit' => $qtyResep[$x],
                'tgl' => $tgl,
                'no_nota' => 'TSP' . $no_urutan,
                'kredit' => '0',
                'id_jurnal' => $max_id->id_jurnal,
                'id_merk_bahan' => $id_merk_bahan[$x],
                'id_satuan_beli' => $id_satuanBeli[$x],
                'unit_prize' => $ttl_rp[$x]
            ];
            DB::table('stok_ts')->insert($data);
        }

        for ($x = 0; $x < count($id_akun_lain); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_akun' => $id_akun_lain[$x],
                'ket' => "Biaya lain-lain",
                'no_nota' => 'TSP' . $no_urutan,
                'debit' => $debit_lain[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TSP' . $no_urutan,
                'id_lokasi' => '1',
                'urutan' => $no_urutan,
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function get_biaya_lain(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get()
        ];

        return view('jurnal_pengeluaran.get_biaya_lain', $data);
    }

    public function tambah_jurnal_lain(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get(),
            'count' => $r->count,
        ];

        return view('jurnal_pengeluaran.tbhget_biaya_lain', $data);
    }

    public function edit_jurnal(Request $r)
    {
        $nota =  $r->no_nota;

        $debit = DB::selectOne("SELECT a.id_akun, a.ket, a.no_urutan, b.nm_akun FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.no_nota = '$nota' and a.debit !=  '0' and a.ket !='Biaya lain-lain'");

        $debit2 = DB::select("SELECT c.id_stok_ts, c.id_bahan, d.id , d.n, c.id_merk_bahan,  a.id_satuan, a.qty, c.unit_prize, c.debit, c.ppn
        FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        LEFT JOIN stok_ts AS c ON c.id_jurnal = a.id_jurnal
        LEFT JOIN tb_satuan AS d ON d.id = c.id_satuan 
        where a.no_nota = '$nota' and a.debit !=  '0' and a.ket !='Biaya lain-lain'");

        $lain = DB::select("SELECT a.id_akun, a.ket, a.no_urutan, b.nm_akun , a.debit FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.no_nota = '$nota' and a.debit !=  '0' and a.ket ='Biaya lain-lain'");

        $kredit = DB::selectOne("SELECT a.no_nota, a.tgl, a.id_akun, b.nm_akun, a.kredit FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.no_nota = '$nota' and a.kredit !=  '0' ");
        $data = [
            'nota' => $nota,
            'akun' => DB::table('tb_akun')->where('id_lokasi', '1')->get(),
            'debit' => $debit,
            'kredit' => $kredit,
            'satuan' => DB::table('tb_satuan')->get(),
            'debit2' => $debit2,
            'lain' => $lain,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', 1 == 1 ? 1 : 2]])->get(),
        ];

        return view('jurnal_pengeluaran.edit_jurnal', $data);
    }

    public function edit_stok_daging(Request $r)
    {
        $tgl = $r->tgl;
        $id_akun = $r->id_akun;
        $metode = $r->metode;
        $no_id = $r->no_id;
        $keterangan = $r->keterangan;
        $total = $r->total;
        $no_nota = $r->no_nota;

        $id_list_bahan = $r->id_list_bahan;
        $id_satuan = $r->id_satuan;
        $id_merk_bahan = $r->id_merk_bahan;
        $id_satuanBeli = $r->id_satuanBeli;
        $qty = $r->qty;
        $ttl_rp = $r->ttl_rp;
        $qtyResep = $r->qtyResep;
        $t_rp = $r->t_rp;
        $ppn = $r->ppn;
        $id_akun_lain = $r->id_akun_lain;
        $debit_lain = $r->debit_lain;

        DB::table('tb_jurnal')->where('no_nota', $no_nota)->delete();
        DB::table('stok_ts')->where('no_nota', $no_nota)->delete();


        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => 'testing',
            'no_nota' => 'TSP' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TSP' . $no_urutan,
            'id_lokasi' => '1',
            'urutan' => $no_urutan,
        ];
        DB::table('tb_jurnal')->insert($data);

        for ($x = 0; $x < count($id_list_bahan); $x++) {
            $total =  $t_rp[$x] + $ppn[$x];
            $bahan =  DB::table('tb_list_bahan')->where('id_list_bahan', $id_list_bahan[$x])->first();
            $data = [
                'tgl' => $tgl,
                'id_akun' => $id_akun,
                'ket' => $keterangan,
                'ket2' => $bahan->nm_bahan,
                'no_nota' => 'TSP' . $no_urutan,
                'debit' => $total,
                'qty' => $qty[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TSP' . $no_urutan,
                'id_lokasi' => '1',
                'urutan' => $no_urutan,
                'no_urutan' => $no_id
            ];
            DB::table('tb_jurnal')->insert($data);
            $max_id = DB::selectOne("SELECT max(a.id_jurnal) as id_jurnal FROM tb_jurnal as a");



            $data = [
                'id_bahan' => $id_list_bahan[$x],
                'id_satuan' => $id_satuan[$x],
                'debit' => $qtyResep[$x],
                'tgl' => $tgl,
                'no_nota' => 'TSP' . $no_urutan,
                'kredit' => '0',
                'id_jurnal' => $max_id->id_jurnal,
                'id_merk_bahan' => $id_merk_bahan[$x],
                'id_satuan_beli' => $id_satuanBeli[$x],
                'unit_prize' => $ttl_rp[$x]
            ];
            DB::table('stok_ts')->insert($data);
        }

        for ($x = 0; $x < count($id_akun_lain); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_akun' => $id_akun_lain[$x],
                'ket' => "Biaya lain-lain",
                'no_nota' => 'TSP' . $no_urutan,
                'debit' => $debit_lain[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TSP' . $no_urutan,
                'id_lokasi' => '1',
                'urutan' => $no_urutan,
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function hapus_stok_daging(Request $r)
    {
        $nota = $r->no_nota;
        DB::table('tb_jurnal')->where('no_nota', $nota)->delete();
        DB::table('stok_ts')->where('no_nota', $nota)->delete();
        return redirect()->route("jurnal_pengeluaran")->with('sukses', 'Data berhasil di hapus');
    }
}
