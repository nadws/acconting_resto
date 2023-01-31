<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimbangController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Timbang',
            'pembelian' => DB::select("SELECT a.timbang,a.tgl,a.admin,a.no_po,sum(b.ttl_rp) as ttl_rp FROM pembelian_purchase as a
            LEFT JOIN purchase as b ON a.id_purchase = b.id_purchase
            GROUP BY a.no_po
            order by a.no_po DESC
            ")
        ];
        return view('timbang.timbang', $data);
    }

    public function timbangView($no_po)
    {
        $data = [
            'title' => 'Detail Timbang',
            'pembelian' => DB::select("SELECT a.timbang,a.ttl_rp,a.id_pembelian_purchase as id_pembelian,a.no_po,a.qty,a.h_satuan,b.id_bahan,b.id_satuan_beli FROM `pembelian_purchase` as a
            LEFT JOIN purchase as b ON a.id_purchase = b.id_purchase
            WHERE a.no_po = '$no_po' AND a.timbang = 'T' GROUP BY b.id_bahan;"),
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po
        ];
        return view('timbang.timbang_detail', $data);
    }

    public function timbangEdit($no_po)
    {
        $getNoPo = DB::table('timbang_purchase')->where('no_po', $no_po)->get();
        $data = [
            'title' => 'Detail Edit Timbang',
            'pembelian' => DB::select("SELECT b.timbang,a.id_timbang as id_pembelian,c.id_bahan,c.id_satuan_beli,a.h_satuan,a.qty,b.ttl_rp FROM `timbang_purchase` as a
            LEFT JOIN pembelian_purchase as b on a.id_pembelian = b.id_pembelian_purchase
            LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
            WHERE a.no_po = '$no_po' GROUP BY c.id_bahan;"),
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'getNoPo' => $getNoPo
        ];
        return view('timbang.timbang_detail', $data);
    }

    public function save_timbang(Request $r)
    {
        $user = 'aldi';
        $id_lokasi = 1;
        if ($r->timbang[0] == 'T') {
            for ($i = 0; $i < count($r->id_pembelian); $i++) {
                DB::table('timbang_purchase')->insert([
                    'tgl' => $r->tgl,
                    'no_po' => $r->no_po,
                    'qty' => $r->qty[$i],
                    'h_satuan' => $r->h_satuan[$i],
                    'admin' => $user,
                    'id_pembelian' => $r->id_pembelian[$i],
                    'qty' => $r->qty[$i],
                    'ttl_rp' => $r->ttl_rp[$i],
                    'ket' => $r->ket,
                    'id_lokasi' => $id_lokasi
                ]);

                DB::table('pembelian_purchase')->where('no_po', $r->no_po)->update(['timbang' => 'Y']);
            }
        } else {
            for ($i = 0; $i < count($r->id_pembelian); $i++) {
                DB::table('timbang_purchase')->where('id_timbang', $r->id_pembelian[$i])->update([
                    'tgl' => $r->tgl,
                    'qty' => $r->qty[$i],
                    'h_satuan' => $r->h_satuan[$i],
                    'admin' => $user,
                    'qty' => $r->qty[$i],
                    'ttl_rp' => $r->ttl_rp[$i],
                    'ket' => $r->ket,
                ]);
            }
        }
        return redirect()->route('timbang')->with('sukses', 'Berhasil timbang');
    }

    public function detail_timbang(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, e.qty, e.h_satuan as rp_satuan,e.ttl_rp,d.tgl,d.qty as qty_timbang,d.h_satuan as hrga_satuan_timbang,d.ttl_rp as ttl_rp_timbang FROM timbang_purchase as d
        LEFT JOIN pembelian_purchase as e ON d.id_pembelian = e.id_pembelian_purchase
        LEFT JOIN purchase as a ON a.id_purchase = e.id_purchase
                left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
                left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
                where a.no_po = '$no_po'
                order by a.id_purchase DESC
                ");

        $detail2 = DB::selectOne("SELECT a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, e.qty, e.h_satuan as rp_satuan,e.ttl_rp,d.tgl,d.qty as qty_timbang,d.h_satuan as hrga_satuan_timbang,d.ttl_rp as ttl_rp_timbang FROM timbang_purchase as d
        LEFT JOIN pembelian_purchase as e ON d.id_pembelian = e.id_pembelian_purchase
        LEFT JOIN purchase as a ON a.id_purchase = e.id_purchase
                left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
                left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
                where a.no_po = '$no_po'
                order by a.id_purchase DESC
                ");

        $data = [
            'po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('timbang.detail2', $data);
    }
}
