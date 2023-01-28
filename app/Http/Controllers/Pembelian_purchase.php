<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pembelian_purchase extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Pengajuan Pembelian',
            'purchase' => DB::select("SELECT a.tgl, a.no_po, a.admin, sum(a.ttl_rp) as total FROM purchase as a group by a.no_po order by a.id_purchase DESC"),
        ];
        return view('sistem_po.index', $data);
    }
}
