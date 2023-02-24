<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function pembayaran()
    {
        $datas = DB::select("SELECT a.selesai, b.dimuka, a.tgl,a.admin,a.no_po,sum(b.ttl_rp) as ttl_rp,d.nm_bahan FROM timbang_purchase as a
        LEFT JOIN pembelian_purchase as b ON a.id_pembelian = b.id_pembelian_purchase
        LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
        LEFT JOIN tb_list_bahan as d ON c.id_bahan = d.id_list_bahan
        LEFT JOIN tb_satuan as e ON c.id_satuan_beli = e.id_satuan
        WHERE b.timbang = 'Y' 
        GROUP BY a.no_po
        ORDER BY a.id_timbang DESC
        ");
        $data = [
            'title' => 'Pembayaran',
            'pembayaran' => $datas
        ];
        return view('pembayaran.pembayaran', $data);
    }

    public function pembayaran_bahan(Request $r)
    {
        $nopo = $r->no_po;
        $detail = DB::select("SELECT a.tgl,a.admin,a.no_po,sum(b.ttl_rp) as ttl_rp,d.nm_bahan , a.qty, e.nm_satuan,
        a.h_satuan, c.id_satuan_beli as id_satuan , c.id_bahan
       FROM timbang_purchase as a
       LEFT JOIN pembelian_purchase as b ON a.id_pembelian = b.id_pembelian_purchase
       LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
       LEFT JOIN tb_list_bahan as d ON c.id_bahan = d.id_list_bahan
       LEFT JOIN tb_satuan as e ON a.id_satuan_timbang = e.id_satuan
       WHERE a.no_po = '$nopo'
       GROUP BY a.id_timbang");
        $detail2 = DB::selectOne("SELECT a.tgl,a.admin,a.no_po,sum(b.ttl_rp) as ttl_rp,d.nm_bahan , a.qty, e.nm_satuan,
        a.h_satuan, c.id_satuan_beli as id_satuan
       FROM timbang_purchase as a
       LEFT JOIN pembelian_purchase as b ON a.id_pembelian = b.id_pembelian_purchase
       LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
       LEFT JOIN tb_list_bahan as d ON c.id_bahan = d.id_list_bahan
       LEFT JOIN tb_satuan as e ON c.id_satuan_beli = e.id_satuan
       WHERE a.no_po = '$nopo'
       GROUP BY a.id_timbang");

        $biaya_tambahan = DB::select("SELECT a.id_akun, b.nm_akun, a.rupiah FROM purchase_biaya as a left join tb_akun_fix as b on b.id_akun = a.id_akun
        where a.sub_no_po ='$nopo'
        ");


        $data = [
            'no_po' => $nopo,
            'detail' => $detail,
            'detail2' => $detail2,
            'biaya' => $biaya_tambahan,
            'akun' => DB::table('tb_akun_fix')->where([['id_kategori', '1'], ['id_penyesuaian', '0']])->get()

        ];
        return view('pembayaran.perencanaan', $data);
    }

    public function save_pembukuan(Request $r)
    {
        $tgl = $r->tgl;
        $id_akun = $r->id_akun;
        $id_bahan = $r->id_bahan;
        $qty = $r->qty;
        $id_satuan = $r->id_satuan;
        $ttl_rp = $r->ttl_rp;
        $no_po = $r->no_po;

        $id_akun_tambahan = $r->id_akun_tambahan;
        $rupiah = $r->rupiah;
        $akun2 = $r->akun2;
        $total_rp = $r->total_rp;
        $h_satuan = $r->h_satuan;

        $akun2 = $r->akun2;
        $pembayaran = $r->pembayaran;

        for ($i = 0; $i < count($akun2); $i++) {
            $data = [
                'tgl' => $tgl,
                'id_akun' => $akun2[$i],
                'kredit' => $pembayaran[$i],
                'id_buku' => '3',
                'no_nota' => $no_po,
                'ket' => 'Pembayaran purchase ' . $no_po,
                'admin' => 'Nanda'
            ];
            DB::table('tb_jurnal')->insert($data);
        }


        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_akun' => '7',
                'debit' => $ttl_rp[$x],
                'id_buku' => '3',
                'no_nota' => $no_po,
                'ket' => 'Pembayaran purchase ' . $no_po,
                'id_satuan' => $id_satuan[$x],
                'qty' => $qty[$x],
                'admin' => 'Nanda'
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        for ($x = 0; $x < count($id_akun_tambahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_akun' => $id_akun_tambahan[$x],
                'debit' => $rupiah[$x],
                'id_buku' => '3',
                'no_nota' => $no_po,
                'ket' => 'Biaya lain-lain ' . $no_po,
                'admin' => 'Nanda'
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_bahan' => $id_bahan[$x],
                'debit' => $qty[$x],
                'no_nota' => $no_po,
                'admin' => 'Nanda',
                'id_satuan' => $id_satuan[$x],
                'id_satuan_beli' => $id_satuan[$x],
                'unit_prize' => $h_satuan[$x]
            ];
            DB::table('stok_ts')->insert($data);
        }


        DB::table('timbang_purchase')->where('no_po', $no_po)->update(['selesai' => 'Y']);
        DB::table('pembelian_purchase')->where('sub_no_po', $no_po)->update(['selesai' => 'Y']);




        return redirect()->route("pembayaran")->with('sukses', 'Data berhasil di input');
    }

    public function cancel_pembukuan(Request $r)
    {
        $no_po = $r->no_po;

        DB::table('tb_jurnal')->where('no_nota', $no_po)->delete();
        DB::table('stok_ts')->where('no_nota', $no_po)->delete();
        DB::table('timbang_purchase')->where('no_po', $no_po)->update(['selesai' => 'T']);
        DB::table('pembelian_purchase')->where('sub_no_po', $no_po)->update(['selesai' => 'T']);
        return redirect()->route("pembayaran")->with('sukses', 'Data berhasil di hapus');
    }

    public function tambah_baris_pembyaran(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun_fix')->where([['id_kategori', '1'], ['id_penyesuaian', '0']])->get(),
            'count' => $r->count
        ];

        return view('pembayaran.tambah_bayar', $data);
    }
}
