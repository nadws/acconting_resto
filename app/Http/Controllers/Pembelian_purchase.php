<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pembelian_purchase extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Pembelian Bahan',
            'purchase' => DB::select("SELECT a.tgl, a.no_po, a.admin, sum(a.ttl_rp) as total, count(a.beli) AS po, b.beli, b.total_beli, b.admin as admin_beli, b.timbang
            FROM purchase as a 
            left JOIN (
				SELECT SUM(b.ttl_rp) AS total_beli, b.no_po, b.admin, b.timbang, COUNT(b.id_purchase) AS beli
				FROM pembelian_purchase as b
				GROUP BY b.no_po
				) AS b ON b.no_po = a.no_po
            group by a.no_po 
            order by a.id_purchase DESC"),
        ];
        return view('pembelian_po.index', $data);
    }

    public function tambah_beli(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.id_purchase,a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po' AND a.beli = 'T'");

        $detail2 = DB::selectOne("SELECT a.id_purchase, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Pembelian Bahan',
            'no_po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('pembelian_po.tambah', $data);
    }

    public function save_pembelian_po(Request $r)
    {
        if ($r->action == 'dimuka') {
            $tgl = $r->tgl;
            $no_po = $r->no_po;
            $ket = $r->ket;

            $id_purchase = $r->id_purchase;
            $qty = $r->qty;
            $h_satuan = $r->h_satuan;
            $ttl_rp = $r->ttl_rp;
            $cek = $r->cek;
            $ambil = DB::table('pembelian_purchase')->where('no_po', $no_po)->latest('urutan')->first();
            $urutan = empty($ambil) ? 1 : $ambil->urutan + 1;
            $sub_po = "$no_po-" . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            if (!empty($r->cek)) {
                for ($x = 0; $x < count($cek); $x++) {
                    $data = [
                        'tgl' => $tgl,
                        'no_po' => $no_po,
                        'sub_no_po' => $sub_po,
                        'urutan' => $urutan,
                        'ket' => $ket,
                        'id_purchase' => $cek[$x],
                        'qty' => $qty[$x],
                        'h_satuan' => $h_satuan[$x],
                        'ttl_rp' => $ttl_rp[$x],
                        'admin' => 'Aldi',
                    ];
                    DB::table('pembelian_purchase')->insert($data);
                    DB::table('purchase')->where('id_purchase', $cek[$x])->update(['beli' => 'Y']);
                }
            }

            return redirect()->route("tambah_pembayaran_dimuka", ['no_po' => $no_po, 'sub_no_po' => $sub_po]);
        } else {
            $tgl = $r->tgl;
            $no_po = $r->no_po;
            $ket = $r->ket;

            $id_purchase = $r->id_purchase;
            $qty = $r->qty;
            $h_satuan = $r->h_satuan;
            $ttl_rp = $r->ttl_rp;
            $cek = $r->cek;
            $ambil = DB::table('pembelian_purchase')->where('no_po', $no_po)->latest('urutan')->first();
            $urutan = empty($ambil) ? 1 : $ambil->urutan + 1;
            $sub_po = "$no_po-" . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            if (!empty($r->cek)) {
                for ($x = 0; $x < count($cek); $x++) {
                    $data = [
                        'tgl' => $tgl,
                        'no_po' => $no_po,
                        'sub_no_po' => $sub_po,
                        'urutan' => $urutan,
                        'ket' => $ket,
                        'id_purchase' => $cek[$x],
                        'qty' => $qty[$x],
                        'h_satuan' => $h_satuan[$x],
                        'ttl_rp' => $ttl_rp[$x],
                        'admin' => 'Aldi',
                    ];
                    DB::table('pembelian_purchase')->insert($data);
                    DB::table('purchase')->where('id_purchase', $cek[$x])->update(['beli' => 'Y']);
                }
            }

            return redirect()->route("tambah_pembayaran_dipasar", ['no_po' => $no_po, 'sub_no_po' => $sub_po]);
        }
    }

    public function tambah_pembayaran_dimuka(Request $r)
    {
        $data = [];
        return view('pembelian_po.dibayar_dimuka', $data);
    }

    public function tambah_pembayaran_dipasar(Request $r)
    {
        $no_po = $r->no_po;
        $sub_no_po = $r->sub_no_po;


        $detail = DB::select("SELECT d.sub_no_po,a.id_purchase,d.tgl, d.no_po, b.nm_bahan, c.nm_satuan, d.qty, d.h_satuan as rp_satuan, d.ttl_rp FROM pembelian_purchase as d
        LEFT JOIN purchase as a ON a.id_purchase = d.id_purchase
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where d.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.id_purchase, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Pembelian Bahan',
            'no_po' => $no_po,
            'akun' => DB::table('tb_akun_fix')->whereIn('id_kategori', [6])->get(),
            'purchase' => $detail,
            'detail2' => $detail2,
            'sub_no_po' => $sub_no_po
        ];

        return view('pembelian_po.dibayar_dimuka', $data);
    }

    public function tambah_biaya_lain2(Request $r)
    {
        $data = [
            'title' => 'Tambah Baris',
            'akun' => DB::table('tb_akun_fix')->whereIn('id_kategori', [6])->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'count' => $r->count
        ];
        return view('pembelian_po.tambah_biaya_lain2', $data);
    }

    public function save_pembelian_po_pasar(Request $r)
    {
        for ($i = 0; $i < count($r->id_akun); $i++) {
            if (empty($r->id_akun[$i])) {
                # code...
            } else {
                $data = [
                    'sub_no_po' => $r->sub_no_po,
                    'id_akun' => $r->id_akun[$i],
                    'rupiah' => $r->rupiah[$i],
                    'id_lokasi' => 1,
                ];
                DB::table('purchase_biaya')->insert($data);
            }
        }
        return redirect()->route('pembelian_po')->with('sukses', 'Sukses tambah pembelian');
    }

    public function edit_save_pembelian_po(Request $r)
    {
        $tgl = $r->tgl;
        $no_po = $r->no_po;
        $ket = $r->ket;
        DB::table('pembelian_purchase')->where('no_po', $no_po)->delete();

        $id_purchase = $r->id_purchase;
        $qty = $r->qty;
        $h_satuan = $r->h_satuan;
        $ttl_rp = $r->ttl_rp;

        for ($x = 0; $x < count($id_purchase); $x++) {
            $data = [
                'tgl' => $tgl,
                'no_po' => $no_po,
                'ket' => $ket,
                'id_purchase' => $id_purchase[$x],
                'qty' => $qty[$x],
                'h_satuan' => $h_satuan[$x],
                'ttl_rp' => $ttl_rp[$x],
                'admin' => 'Aldi',

            ];
            DB::table('pembelian_purchase')->insert($data);

            $data = [
                'beli' => 'Y'
            ];
            DB::table('purchase')->where('no_po', $no_po)->update($data);
        }
        return redirect()->route("pembelian_po")->with('sukses', 'Data berhasil di input');
    }

    public function detail_po2(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp, 

        d.qty AS qty_beli, d.h_satuan AS hrga_satuan_beli, d.ttl_rp AS ttl_rp_pembelian
        
        FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        left join pembelian_purchase as d on d.id_purchase = a.id_purchase
        where a.no_po = '$no_po'");

        $detail2 = DB::selectOne("SELECT a.admin, a.id_purchase, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('pembelian_po.detail', $data);
    }

    public function print_pembelian(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp, 

        d.qty AS qty_beli, d.h_satuan AS hrga_satuan_beli, d.ttl_rp AS ttl_rp_pembelian
        
        FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        left join pembelian_purchase as d on d.id_purchase = a.id_purchase
        where a.no_po = '$no_po'");

        $detail2 = DB::selectOne("SELECT a.admin, a.id_purchase, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Pembelian PO',
            'po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('pembelian_po.print', $data);
    }

    public function edit_pembelian(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.urutan, a.id_purchase, a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp, 

        d.qty AS qty_beli, d.h_satuan AS hrga_satuan_beli, d.ttl_rp AS ttl_rp_pembelian
        
        FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        left join pembelian_purchase as d on d.id_purchase = a.id_purchase
        where a.no_po = '$no_po'");

        $detail2 = DB::selectOne("SELECT  a.urutan, a.id_purchase, a.admin, a.id_purchase, a.tgl, 
        a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp 
        FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Edit Bahan',
            'no_po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('pembelian_po.edit', $data);
    }

    public function print_detail(Request $r)
    {
        $no_po =  $r->no_po;
        $sub_no = DB::select("SELECT a.sub_no_po FROM pembelian_purchase as a where a.no_po = '$no_po' group by a.sub_no_po");

        $data = [
            'sub_no' => $sub_no
        ];
        return view('pembelian_po.print_detail', $data);
    }
}
