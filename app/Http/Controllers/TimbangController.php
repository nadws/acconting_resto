<?php

namespace App\Http\Controllers;

use App\Mail\Timbangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TimbangController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Timbang',
            'pembelian' => DB::select("SELECT a.timbang,a.tgl,a.admin,a.no_po, a.sub_no_po, sum(b.ttl_rp) as ttl_rp FROM pembelian_purchase as a
            LEFT JOIN purchase as b ON a.id_purchase = b.id_purchase
            WHERE a.beli = 'Y'
            GROUP BY a.sub_no_po
            order by a.no_po DESC;
            ")
        ];
        return view('timbang.timbang', $data);
    }

    public function timbangView($no_po)
    {
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang, a.id_pembelian_purchase as id_pembelian, b.id_bahan, b.id_satuan_beli
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        WHERE a.beli = 'Y' AND a.sub_no_po = '$no_po'");
        $data = [
            'title' => 'Detail Timbang',
            'pembelian' => $detail,
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'akun' => DB::table('tb_akun_fix')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get()
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

            $qty_beli = $r->qty_beli;
            $qty = $r->qty;

            $total_qty = 0;
            $total_qty_beli = 0;
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
                DB::table('pembelian_purchase')->where('sub_no_po', $r->no_po)->update(['timbang' => 'Y']);

                $total_qty += $qty[$i];
                $total_qty_beli += $qty_beli[$i];
            }

            if ($total_qty_beli > $total_qty) {
                Mail::to('nandw567@gmail.com')->send(new Timbangan('nandw567@gmail.com'));
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
        $sub_no_po = $r->sub_no_po;
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        WHERE a.beli = 'Y' AND a.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.*, c.nm_bahan, d.nm_satuan
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        WHERE a.beli = 'Y' AND a.sub_no_po = '$sub_no_po'");
        $data = [
            'po' => $sub_no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('timbang.detail2', $data);
    }

    public function print_nota(Request $r)
    {
        $sub_no_po = $r->sub_no_po;
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        WHERE a.beli = 'Y' AND a.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.*, c.nm_bahan, d.nm_satuan
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        WHERE a.beli = 'Y' AND a.sub_no_po = '$sub_no_po'");
        $data = [
            'po' => $sub_no_po,
            'purchase' => $detail,
            'detail2' => $detail2,
            'title' => 'Print Timbangan'
        ];
        return view('timbang.print', $data);
    }
}
