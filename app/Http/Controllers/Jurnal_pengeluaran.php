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
            ];
            DB::table('tb_jurnal')->insert($data);



            $data = [
                'id_bahan' => $id_list_bahan[$x],
                'id_satuan' => $id_satuan[$x],
                'debit' => $qtyResep[$x],
                'tgl' => $tgl,
                'no_nota' => 'TSP' . $no_urutan,
                'kredit' => '0'
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
}
