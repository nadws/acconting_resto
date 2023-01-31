<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function pembayaran()
    {
        $datas = DB::select("SELECT a.tgl,a.admin,a.no_po,sum(b.ttl_rp) as ttl_rp,d.nm_bahan FROM timbang_purchase as a
        LEFT JOIN pembelian_purchase as b ON a.id_pembelian = b.id_pembelian_purchase
        LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
        LEFT JOIN tb_list_bahan as d ON c.id_bahan = d.id_list_bahan
        LEFT JOIN tb_satuan as e ON c.id_satuan_beli = e.id_satuan
        WHERE b.timbang = 'Y'
        GROUP BY a.no_po;");
        $data = [
            'title' => 'Pembayaran',
            'pembayaran' => $datas
        ];
        return view('pembayaran.pembayaran',$data);
    }

    public function pembayaran_bahan(Request $r)
    {
        $nopo = $r->no_po;
        $data = [
            'no_po' => $nopo,
        ];
        return view('pembayaran.perencanaan', $data);
    }
}
