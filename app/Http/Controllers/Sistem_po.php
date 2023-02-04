<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sistem_po extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Pengajuan Pembelian',
            'purchase' => DB::select("SELECT a.tgl, a.no_po, a.admin, sum(a.ttl_rp) as total, a.beli FROM purchase as a group by a.no_po order by a.id_purchase DESC"),
        ];
        return view('sistem_po.index', $data);
    }

    public function tambah_po(Request $r)
    {
        $max = DB::selectOne("SELECT max(a.urutan) as max_urutan FROM purchase as a");

        if (empty($max->max_urutan)) {
            $no_po = '1001';
        } else {
            $no_po = $max->max_urutan + 1;
        }

        $data = [
            'title' => 'Tambah Pengajuan Pembelian',
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po
        ];
        return view('sistem_po.tambah', $data);
    }

    public function tambah_baris_po(Request $r)
    {
        $data = [
            'title' => 'Tambah Pengajuan Pembelian',
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'count' => $r->count
        ];
        return view('sistem_po.tambah_baris', $data);
    }

    public function save_po(Request $r)
    {
        $tgl = $r->tgl;
        // $no_po = $r->no_po;
        $ket = $r->ket;

        $id_bahan = $r->id_bahan;
        $qty = $r->qty;
        $id_satuan = $r->id_satuan;
        $h_satuan = $r->h_satuan;
        $ttl_rp = $r->ttl_rp;

        $max = DB::selectOne("SELECT max(a.urutan) as max_urutan FROM purchase as a");

        if (empty($max->max_urutan)) {
            $no_po = '1001';
        } else {
            $no_po = $max->max_urutan + 1;
        }

        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'no_po' => 'PO' . $no_po,
                'ket' => $ket,
                'id_bahan' => $id_bahan[$x],
                'qty' => $qty[$x],
                'id_satuan_beli' => $id_satuan[$x],
                'rp_satuan' => $h_satuan[$x],
                'ttl_rp' => $ttl_rp[$x],
                'admin' => 'Nanda',
                'urutan' => $no_po
            ];
            DB::table('purchase')->insert($data);
        }
        return redirect()->route("sistem_po")->with('sukses', 'Data berhasil di input');
    }
    public function edit_save_po(Request $r)
    {
        $tgl = $r->tgl;
        $no_po = $r->no_po;

        DB::table('purchase')->where('no_po', $no_po)->delete();
        DB::table('pembelian_purchase')->where('no_po', $no_po)->delete();

        $ket = $r->ket;

        $id_bahan = $r->id_bahan;
        $qty = $r->qty;
        $id_satuan = $r->id_satuan;
        $h_satuan = $r->h_satuan;
        $ttl_rp = $r->ttl_rp;
        $urutan = $r->urutan;



        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'no_po' => $no_po,
                'ket' => $ket,
                'id_bahan' => $id_bahan[$x],
                'qty' => $qty[$x],
                'id_satuan_beli' => $id_satuan[$x],
                'rp_satuan' => $h_satuan[$x],
                'ttl_rp' => $ttl_rp[$x],
                'admin' => 'Nanda',
                'urutan' => $urutan
            ];
            DB::table('purchase')->insert($data);
        }
        return redirect()->route("sistem_po")->with('sukses', 'Data berhasil di input');
    }

    public function hrga_terakhir_po(Request $r)
    {
        $id_bahan = $r->id_bahan;
        $max = DB::selectOne("SELECT  max(a.id_purchase) as max_id FROM purchase as a where a.id_bahan = '$id_bahan'");


        $bahan = DB::selectOne("SELECT a.rp_satuan FROM purchase as a where a.id_purchase = '$max->max_id'");

        if (empty($bahan)) {
            echo 0;
        } else {
            echo $bahan->rp_satuan;
        }
    }

    public function detail_po(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");
        $detail2 = DB::selectOne("SELECT a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('sistem_po.detail', $data);
    }

    public function print_po(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");
        $detail2 = DB::selectOne("SELECT a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Print Purchase',
            'po' => $no_po,
            'purchase' => $detail,
            'detail2' => $detail2
        ];
        return view('sistem_po.print', $data);
    }

    public function edit_po(Request $r)
    {
        $no_po = $r->no_po;
        $detail = DB::select("SELECT  a.id_purchase, a.tgl, a.id_bahan, a.id_satuan_beli, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp, a.ket FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");
        $detail2 = DB::selectOne("SELECT a.urutan, a.admin, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp , a.ket FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Edit Pengajuan Pembelian',
            'list_bahan' => DB::table('tb_list_bahan')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'detail' => $detail,
            'detail2' => $detail2
        ];
        return view('sistem_po.edit_po', $data);
    }
}
