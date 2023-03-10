<?php

namespace App\Http\Controllers;

use App\Mail\Timbangan;
use App\Models\Listbahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use SettingHal;
class TimbangController extends Controller
{
    public function index(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $id_user = auth()->user()->id;

        $cekP = DB::table('permission_gudang')->where('url', $r->route()->getName())->first();
        $cek = DB::table('permission_perpage')->where([['id_user', $id_user], ['id_permission_gudang', $cekP->id_permission]])->first();
        if (empty($cek)) {
            return abort(403, 'Akses Tidak ada');
        }

        $data = [
            'title' => 'Timbang',
            'pembelian' => DB::select("SELECT a.pembeli, a.tempat_beli, a.dimuka, a.selesai, a.timbang,a.tgl,a.admin,a.no_po, a.sub_no_po, sum(a.ttl_rp) as ttl_rp, c.lain FROM pembelian_purchase as a
            LEFT JOIN purchase as b ON a.id_purchase = b.id_purchase
            left join ( SELECT sum(c.rupiah) as lain, c.sub_no_po FROM  purchase_biaya as c group by c.sub_no_po ) as c on c.sub_no_po = a.sub_no_po
            where b.id_lokasi = '$id_lokasi'
            GROUP BY a.sub_no_po
            order by a.sub_no_po DESC;
            "),
             'user' => User::whereIn('id_posisi', ['1', '2'])->get(),
             'halaman' => 6,
             // button
 
             'tambah' => SettingHal::btnHal(9,$id_user),
             'update' => SettingHal::btnHal(17,$id_user),
             'print' => SettingHal::btnHal(10,$id_user),

        ];

        return view('timbang.timbang', $data);
    }

    public function timbangView($no_po)
    {
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang, a.id_pembelian_purchase as id_pembelian, b.id_bahan, b.id_satuan_beli, c.id_satuan as id_satuan_bahan

        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        WHERE  a.sub_no_po = '$no_po'");
        $pembelian = DB::table('pembelian_purchase')->where('sub_no_po', $no_po)->first();
        $data = [
            'title' => 'Detail Timbang',
            'pembelian' => $detail,
            'beli' => $pembelian,
            'list_bahan' => Listbahan::all(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'akun' => DB::table('tb_akun_fix')->where(['id_kategori' => '5', 'id_lokasi' => '1'])->get()
        ];
        return view('timbang.timbang_detail', $data);
    }

    public function timbangEdit($no_po)
    {
        $getNoPo = DB::table('timbang_purchase')->where('no_po', $no_po)->get();
        $pembelian = DB::table('pembelian_purchase')->where('sub_no_po', $no_po)->first();
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang, a.id_pembelian_purchase as id_pembelian, b.id_bahan, b.id_satuan_beli, c.id_satuan as id_satuan_bahan
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        WHERE  a.sub_no_po = '$no_po'");
        $data = [
            'title' => 'Detail Edit Timbang',
            'pembelian' => $detail,
            'list_bahan' => Listbahan::all(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'getNoPo' => $getNoPo,
            'beli' => $pembelian,
        ];
        return view('timbang.timbang_detail', $data);
    }

    public function save_timbang(Request $r)
    {
        $user = 'aldi';
        $id_lokasi = 1;
        if ($r->timbang == 'T') {
            $qty_beli = $r->qty_beli;
            $qty = $r->qty;
            $total_qty = 0;
            $total_qty_beli = 0;
            for ($i = 0; $i < count($r->id_pembelian); $i++) {

                if ($r->dimuka[$i] == 'Y') {
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
                        'id_lokasi' => $id_lokasi,
                        'id_satuan_timbang' => $r->id_satuan[$i],
                        'selesai' => 'Y'
                    ]);
                    DB::table('pembelian_purchase')->where('sub_no_po', $r->no_po)->update(['timbang' => 'Y']);
                    $data = [
                        'tgl' => $r->tgl,
                        'id_bahan' => $r->id_bahan[$i],
                        'debit' => $r->qty[$i],
                        'no_nota' => $r->no_po,
                        'admin' => 'Nanda',
                        'id_satuan' => $r->id_satuan[$i],
                        'id_satuan_beli' => $r->id_satuan[$i],
                        'unit_prize' => $r->h_satuan[$i]
                    ];
                    DB::table('stok_ts')->insert($data);
                } else {
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
                        'id_lokasi' => $id_lokasi,
                        'id_satuan_timbang' => $r->id_satuan[$i]
                    ]);
                    DB::table('pembelian_purchase')->where('sub_no_po', $r->no_po)->update(['timbang' => 'Y']);

                    $data = [
                        'tgl' => $r->tgl,
                        'id_bahan' => $r->id_bahan[$i],
                        'debit' => $r->qty[$i],
                        'no_nota' => $r->no_po,
                        'admin' => $user,
                        'id_satuan' => $r->id_satuan[$i],
                        'id_satuan_beli' => $r->id_satuan[$i],
                        'unit_prize' => $r->h_satuan[$i]
                    ];
                    DB::table('stok_ts')->insert($data);
                }



                $total_qty += $qty[$i];
                $total_qty_beli += $qty_beli[$i];
            }

            // if ($total_qty_beli > $total_qty) {
            //     Mail::to('nandw567@gmail.com')->send(new Timbangan('nandw567@gmail.com'));
            // }
        } else {
            $qty_beli = $r->qty_beli;
            $qty = $r->qty;
            $total_qty = 0;
            $total_qty_beli = 0;
            DB::table('stok_ts')->where('no_nota', $r->no_po)->delete();
            DB::table('timbang_purchase')->where('no_po', $r->no_po)->delete();
            for ($i = 0; $i < count($r->id_pembelian); $i++) {

                if ($r->dimuka[$i] == 'Y') {
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
                        'id_lokasi' => $id_lokasi,
                        'id_satuan_timbang' => $r->id_satuan[$i],
                        'selesai' => 'Y'
                    ]);
                    DB::table('pembelian_purchase')->where('sub_no_po', $r->no_po)->update(['timbang' => 'Y']);

                    $data = [
                        'tgl' => $r->tgl,
                        'id_bahan' => $r->id_bahan[$i],
                        'debit' => $r->qty[$i],
                        'no_nota' => $r->no_po,
                        'admin' => 'Nanda',
                        'id_satuan' => $r->id_satuan[$i],
                        'id_satuan_beli' => $r->id_satuan[$i],
                        'unit_prize' => $r->h_satuan[$i]
                    ];
                    DB::table('stok_ts')->insert($data);
                } else {
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
                        'id_lokasi' => $id_lokasi,
                        'id_satuan_timbang' => $r->id_satuan[$i]
                    ]);
                    DB::table('pembelian_purchase')->where('sub_no_po', $r->no_po)->update(['timbang' => 'Y']);

                    $data = [
                        'tgl' => $r->tgl,
                        'id_bahan' => $r->id_bahan[$i],
                        'debit' => $r->qty[$i],
                        'no_nota' => $r->no_po,
                        'admin' => $user,
                        'id_satuan' => $r->id_satuan[$i],
                        'id_satuan_beli' => $r->id_satuan[$i],
                        'unit_prize' => $r->h_satuan[$i]
                    ];
                    DB::table('stok_ts')->insert($data);
                }



                $total_qty += $qty[$i];
                $total_qty_beli += $qty_beli[$i];
            }
        }
        return redirect()->route('timbang')->with('sukses', 'Berhasil timbang');
    }

    public function detail_timbang(Request $r)
    {
        $sub_no_po = $r->sub_no_po;
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang, f.nm_satuan as satuan_timbang
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        LEFT JOIN tb_satuan AS f ON f.id_satuan= e.id_satuan_timbang
        WHERE  a.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.*, c.nm_bahan, d.nm_satuan
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        WHERE  a.sub_no_po = '$sub_no_po'");
        $data = [
            'po' => $sub_no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('timbang.detail2', $data);
    }

    public function print_timbang(Request $r)
    {
        $sub_no_po = $r->sub_no_po;
        $detail = DB::select("SELECT  a.*, c.nm_bahan, d.nm_satuan, e.qty AS qty_timbang, e.h_satuan AS rp_satuan_timbang, 
        e.ttl_rp AS ttl_rp_timbang, f.nm_satuan as satuan_timbang
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        LEFT JOIN timbang_purchase AS e ON e.id_pembelian = a.id_pembelian_purchase
        LEFT JOIN tb_satuan AS f ON f.id_satuan= e.id_satuan_timbang
        WHERE  a.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.*, c.nm_bahan, d.nm_satuan, b.id_lokasi
        FROM pembelian_purchase AS a
        LEFT JOIN purchase AS b ON b.id_purchase = a.id_purchase
        LEFT JOIN tb_list_bahan AS c ON c.id_list_bahan = b.id_bahan
        LEFT JOIN tb_satuan AS d ON d.id_satuan= b.id_satuan_beli
        WHERE  a.sub_no_po = '$sub_no_po'");
        $data = [
            'po' => $sub_no_po,
            'purchase' => $detail,
            'detail2' => $detail2,
            'title' => 'Print Timbangan'
        ];
        return view('timbang.print', $data);
    }
}
