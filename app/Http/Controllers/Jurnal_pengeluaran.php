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
        left join tb_akun_fix as b on b.id_akun = a.id_akun
        where a.tgl BETWEEN '$tgl1' and '$tgl2' and a.id_buku = '3'
        order by a.id_jurnal DESC
        ");
        $data = [
            'title' => 'Jurnal Pengeluaran',
            'jurnal' => $j_pengeluaran,
            'akun' => DB::table('tb_akun_fix')->where('id_lokasi', '1')->get()
        ];
        return view('jurnal_pengeluaran.index', $data);
    }

    public function get_isi_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun_fix')->where('id_akun', $id)->first();
        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', $akun->id_kategori_makanan]])->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $akun->id_akun)->get(),
            'kelompok' => DB::table('tb_kelompok_aktiva')->orderBy('id_kelompok', 'ASC')->get()
        ];
        if ($akun->id_kategori == '1') {
            if ($akun->id_penyesuaian == '4') {
                if ($akun->jenis_gudang == '1') {
                    return view('jurnal_pengeluaran.get_isi_jurnal', $data);
                } else {
                    return view('jurnal_pengeluaran.get_isi_jurnal2', $data);
                }
            } elseif ($akun->id_penyesuaian == '2') {
                return view('get_jurnal.get_isi_aktiva', $data);
            } else {
                # code...
            }
        } else {
            if ($akun->id_kategori == '5' || $akun->id_kategori == '7') {
                return view('jurnal_pengeluaran.get_jurnal_biaya', $data);
            } else {
                # code...
            }
        }
    }

    public function get_satuan_bahan(Request $r)
    {
        $id_list = $r->id_list_bahan;

        $list =  DB::table('tb_list_bahan')->where('id_list_bahan', $id_list)->first();
        $d = DB::table('tb_satuan')->where('id_satuan', $list->id_satuan)->first();


        $output = [
            'id_satuan' => $d->id_satuan,
            'satuan' => $d->nm_satuan
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
        $akun = DB::table('tb_akun_fix')->where('id_akun', $id)->first();


        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', $akun->id_kategori_makanan]])->get(),
            'count' => $r->count,
        ];

        return view('jurnal_pengeluaran.get_isi_jurnal_tambah', $data);
    }
    public function tambah_jurnal_barang(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun_fix')->where('id_akun', $id)->first();


        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', $akun->id_kategori_makanan]])->get(),
            'count' => $r->count,
        ];

        return view('jurnal_pengeluaran.get_isi_jurnal_tambah2', $data);
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


        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => $keterangan,
            'no_nota' => 'TKM' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TKM' . $no_urutan,
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
                'no_nota' => 'TKM' . $no_urutan,
                'debit' => $total,
                'qty' => $qty[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TKM' . $no_urutan,
                'id_lokasi' => '1',
                'urutan' => $no_urutan,
                'no_urutan' => $no_id
            ];
            DB::table('tb_jurnal')->insert($data);
            $max_id = DB::selectOne("SELECT max(a.id_jurnal) as id_jurnal FROM tb_jurnal as a");



            $data = [
                'id_bahan' => $id_list_bahan[$x],
                'id_satuan' => $id_satuan[$x],
                'debit' => empty($qtyResep[$x]) ? $qty[$x] : $qtyResep[$x],
                'tgl' => $tgl,
                'no_nota' => 'TKM' . $no_urutan,
                'kredit' => '0',
                'id_jurnal' => $max_id->id_jurnal,
                'id_merk_bahan' => $id_merk_bahan[$x],
                'id_satuan_beli' => $id_satuanBeli[$x],
                'unit_prize' => $ttl_rp[$x]
            ];
            DB::table('stok_ts')->insert($data);
        }

        if (!empty($id_akun_lain)) {
            for ($x = 0; $x < count($id_akun_lain); $x++) {
                $data = [
                    'tgl' => $tgl,
                    'id_akun' => $id_akun_lain[$x],
                    'ket' => "Biaya lain-lain",
                    'no_nota' => 'TKM' . $no_urutan,
                    'debit' => $debit_lain[$x],
                    'id_buku' => '3',
                    'kd_gabungan' => 'TKM' . $no_urutan,
                    'id_lokasi' => '1',
                    'urutan' => $no_urutan,
                ];
                DB::table('tb_jurnal')->insert($data);
            }
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function get_biaya_lain(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun_fix')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get()
        ];

        return view('jurnal_pengeluaran.get_biaya_lain', $data);
    }

    public function tambah_jurnal_lain(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun_fix')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get(),
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


        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => 'testing',
            'no_nota' => 'TKM' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TKM' . $no_urutan,
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
                'no_nota' => 'TKM' . $no_urutan,
                'debit' => $total,
                'qty' => $qty[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TKM' . $no_urutan,
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
                'no_nota' => 'TKM' . $no_urutan,
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
                'no_nota' => 'TKM' . $no_urutan,
                'debit' => $debit_lain[$x],
                'id_buku' => '3',
                'kd_gabungan' => 'TKM' . $no_urutan,
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

    public function tambah_jurnal_biaya(Request $r)
    {
        $id = $r->id_akun;

        $akun = DB::table('tb_akun_fix')->where('id_akun', $id)->first();
        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,

            'post_center' => DB::table('tb_post_center')->where('id_akun', $akun->id_akun)->get(),
            'count' => $r->count
        ];
        return view('jurnal_pengeluaran.tbhget_biaya_biaya', $data);
    }
    public function tambah_jurnal_biaya2(Request $r)
    {
        $id = $r->id_akun;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();
        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'id_akun' => $id,
            'lBahanDaging' => DB::table('tb_list_bahan')->where([['id_lokasi', 1], ['id_kategori_makanan', $akun->id_kategori_makanan]])->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $akun->id_akun)->get(),
            'count' => $r->count
        ];
        return view('jurnal_pengeluaran.tbhget_biaya_biaya2', $data);
    }

    public function get_save_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun_fix')->where('id_akun', $id)->first();

        if ($akun->id_kategori == '1') {
            if ($akun->id_penyesuaian == '4') {
                echo "biaya-daging";
            } elseif ($akun->id_penyesuaian == '2') {
                echo "biaya-aktiva";
            } else {
                # code...
            }
        } else {
            echo "biaya";
        }
    }

    public function save_jurnal_biaya(Request $r)
    {
        $tgl = $r->tgl;
        $metode = $r->metode;
        $no_id = $r->no_id;
        $tujuan = $r->tujuan;
        $keterangan = $r->keterangan;
        $id_post_center = $r->id_post_center;
        $id_satuanBeli = $r->id_satuanBeli;
        $qty = $r->qty;
        $rupiah = $r->rupiah;
        $id_akun = $r->id_akun;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => 'testing',
            'no_nota' => 'TKM' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TKM' . $no_urutan,
            'id_lokasi' => '1',
            'urutan' => $no_urutan,
        ];
        DB::table('tb_jurnal')->insert($data);

        for ($x = 0; $x < count($no_id); $x++) {
            $data = [
                'no_urutan' => $no_id[$x],
                'id_akun' => $id_akun,
                'tgl' => $tgl,
                'id_lokasi' => '1',
                'no_nota' => 'TKM' . $no_urutan,
                'urutan' => $no_urutan,
                'id_buku' => '3',
                'ket' => $tujuan[$x],
                'ket2' => $keterangan[$x],
                'id_post_center' => $id_post_center[$x],
                'id_satuan' => $id_satuanBeli[$x],
                'qty' => $qty[$x],
                'debit' => $rupiah[$x],
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }
    public function save_jurnal_aktiva(Request $r)
    {
        $tgl = $r->tgl;
        $metode = $r->metode;
        $no_id = $r->no_id;
        $tujuan = $r->tujuan;
        $keterangan = $r->keterangan;
        $id_post_center = $r->id_post_center;
        $id_satuanBeli = $r->id_satuanBeli;
        $qty = $r->qty;
        $rupiah = $r->rupiah;
        $id_akun = $r->id_akun;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_lokasi = '1' ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }

        $data = [
            'tgl' => $tgl,
            'id_akun' => $metode,
            'ket' => 'testing',
            'no_nota' => 'TKM' . $no_urutan,
            'kredit' => $r->total,
            'id_buku' => '3',
            'kd_gabungan' => 'TKM' . $no_urutan,
            'id_lokasi' => '1',
            'urutan' => $no_urutan,
        ];
        DB::table('tb_jurnal')->insert($data);

        for ($x = 0; $x < count($no_id); $x++) {
            $data = [
                'no_urutan' => $no_id[$x],
                'id_akun' => $id_akun,
                'tgl' => $tgl,
                'id_lokasi' => '1',
                'no_nota' => 'TKM' . $no_urutan,
                'urutan' => $no_urutan,
                'id_buku' => '3',
                'ket' => $keterangan[$x],
                'id_post_center' => $id_post_center[$x],
                'id_satuan' => $id_satuanBeli[$x],
                'qty' => $qty[$x],
                'debit' => $rupiah[$x],
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        // $kelompok = DB::table('tb_kelompok_aktiva')->where('id_kelompok', $id_kelompok)->first();
        // $susut = $kelompok->tarif;

        // $data = [
        //     'tgl' => $r->tgl,
        //     'id_post' => $id_post,
        //     'id_kelompok' => $id_kelompok,
        //     'qty' => $qty,
        //     'no_nota' => 'AGR-' . $no_urutan,
        //     'id_satuan' => $id_satuan,
        //     'debit_aktiva' => $debit,
        //     'b_penyusutan' => (($debit * $qty) * $susut) / 12,
        //     'admin' => Auth::user()->name,
        //     'id_akun' => $r->id_akun
        // ];
        // DB::table('aktiva')->insert($data);
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function get_post_aktiva(Request $r)
    {
        $id_kredit = $r->id_kredit;
        $post = DB::select("SELECT * FROM tb_post_center as a where a.id_akun = '$id_kredit' and a.id_post not in (SELECT b.id_post FROM aktiva as b )");

        echo '<option>--Pilih Post Center--</option>';
        foreach ($post as $p) {
            echo "<option value='$p->id_post'>$p->nm_post</option>";
        }
    }
}
