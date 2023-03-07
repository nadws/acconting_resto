<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Pembelian_purchase extends Controller
{
    public function index(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $data = [
            'title' => 'Pembelian Bahan',
            'purchase' => DB::select("SELECT a.tgl, a.no_po, a.admin, sum(a.ttl_rp) as total, count(a.beli) AS po, b.beli, b.total_beli, b.admin as admin_beli, b.timbang
            FROM purchase as a 
            left JOIN (
				SELECT SUM(b.ttl_rp) AS total_beli, b.no_po, b.admin, b.timbang, COUNT(b.id_purchase) AS beli
				FROM pembelian_purchase as b
				GROUP BY b.no_po
				) AS b ON b.no_po = a.no_po
            where a.id_lokasi = '$id_lokasi'
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
                        'admin' => Auth::User()->nama,
                        'dimuka' => 'Y'
                    ];
                    DB::table('pembelian_purchase')->insert($data);
                    // DB::table('purchase')->where('id_purchase', $cek[$x])->update(['beli' => 'Y']);
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
                        'admin' => Auth::User()->nama,
                        'dimuka' => 'T'
                    ];
                    DB::table('pembelian_purchase')->insert($data);
                    // DB::table('purchase')->where('id_purchase', $cek[$x])->update(['beli' => 'Y']);
                }
            }

            return redirect()->route("tambah_pembayaran_dipasar", ['no_po' => $no_po, 'sub_no_po' => $sub_po]);
        }
    }

    public function cancel_pembelian(Request $r)
    {
        $sub_no_po = $r->sub_no_po;
        $no_po = $r->no_po;
        DB::table('pembelian_purchase')->where('sub_no_po', $sub_no_po)->delete();
        return redirect()->route("tambah_beli", ['no_po' => $no_po]);
    }

    public function tambah_pembayaran_dimuka(Request $r)
    {
        $no_po = $r->no_po;
        $sub_no_po = $r->sub_no_po;


        $detail = DB::select("SELECT d.id_purchase, a.id_bahan, c.id_satuan, d.sub_no_po,a.id_purchase,d.tgl, d.no_po, b.nm_bahan, c.nm_satuan, d.qty, d.h_satuan as rp_satuan, d.ttl_rp FROM pembelian_purchase as d
        LEFT JOIN purchase as a ON a.id_purchase = d.id_purchase
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where d.sub_no_po = '$sub_no_po'");

        $detail2 = DB::selectOne("SELECT a.id_purchase, a.tgl, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ket, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Pembayaran dimuka',
            'no_po' => $no_po,
            'akun' => DB::table('tb_akun_fix')->whereIn('id_kategori', [6])->get(),
            'purchase' => $detail,
            'detail2' => $detail2,
            'sub_no_po' => $sub_no_po,
            'akun2' => DB::table('tb_akun_fix')->where([['id_kategori', '1'], ['id_penyesuaian', '0']])->get()
        ];

        return view('pembelian_po.dibayar_dimuka', $data);
    }

    public function tambah_pembayaran_dipasar(Request $r)
    {
        $no_po = $r->no_po;
        $sub_no_po = $r->sub_no_po;


        $detail = DB::select("SELECT d.sub_no_po, a.id_purchase,d.tgl, d.no_po, b.nm_bahan, c.nm_satuan, d.qty, d.h_satuan as rp_satuan, d.ttl_rp FROM pembelian_purchase as d
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

        return view('pembelian_po.dibayar_dipasar', $data);
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
    public function tambah_biaya_lain3(Request $r)
    {
        $data = [
            'title' => 'Tambah Baris',
            'akun' => DB::table('tb_akun_fix')->where([['id_kategori', '1'], ['id_penyesuaian', '0']])->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'count' => $r->count
        ];
        return view('pembelian_po.tambah_biaya_lain3', $data);
    }
    public function save_pembelian_po_dimuka(Request $r)
    {

        $id_akun_pembayaran =  $r->id_akun_pembayaran;
        $rupiah_pembayaran =  $r->rupiah_pembayaran;
        $rp_satuan =  $r->rp_satuan;
        $id_bahan =  $r->id_bahan;
        $id_satuan =  $r->id_satuan;
        $qty =  $r->qty;
        $id_purchase =  $r->id_purchase;
        $id_lokasi = Session::get('id_lokasi');

        for ($i = 0; $i < count($id_akun_pembayaran); $i++) {
            $data = [
                'tgl' => date('Y-m-d'),
                'id_akun' => $id_akun_pembayaran[$i],
                'kredit' => $rupiah_pembayaran[$i],
                'id_buku' => '3',
                'no_nota' => $r->sub_no_po,
                'ket' => 'Pembayaran purchase ' . $r->sub_no_po,
                'admin' => Auth::User()->nama,
                'id_lokasi' => $id_lokasi
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => date('Y-m-d'),
                'id_akun' => '7',
                'debit' => $rp_satuan[$x],
                'id_buku' => '3',
                'no_nota' => $r->sub_no_po,
                'ket' => 'Pembayaran purchase ' . $r->sub_no_po,
                'id_satuan' => $id_satuan[$x],
                'qty' => $qty[$x],
                'admin' => Auth::User()->nama,
                'id_lokasi' => $id_lokasi
            ];
            DB::table('tb_jurnal')->insert($data);



            DB::table('purchase')->where('id_purchase', $id_purchase[$x])->update(['beli' => 'Y']);
        }
        $id_akun = $r->id_akun;
        $rupiah = $r->rupiah;
        for ($x = 0; $x < count($id_akun); $x++) {
            $data = [
                'tgl' => date('Y-m-d'),
                'id_akun' => $id_akun[$x],
                'debit' => $rupiah[$x],
                'id_buku' => '3',
                'no_nota' => $r->sub_no_po,
                'ket' => 'Biaya lain-lain ' . $r->sub_no_po,
                'admin' => Auth::User()->nama,
                'id_lokasi' => $id_lokasi
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        $data = [
            'tgl' => $r->tgl,
            'pembeli' => $r->pembeli,
            'tempat_beli' => $r->tempat_beli,
        ];
        DB::table('pembelian_purchase')->where('sub_no_po', $r->sub_po)->update($data);

        return redirect()->route('pembelian_po')->with('sukses', 'Sukses tambah pembelian');
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
        $id_purchase = $r->id_purchase;

        for ($x = 0; $x < count($id_purchase); $x++) {
            $data = [
                'beli' => 'Y'
            ];
            DB::table('purchase')->where('id_purchase', $id_purchase[$x])->update($data);
        }
        $data = [
            'tgl' => $r->tgl,
            'pembeli' => $r->pembeli,
            'tempat_beli' => $r->tempat_beli,
        ];
        DB::table('pembelian_purchase')->where('sub_no_po', $r->sub_po)->update($data);

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
                'admin' => Auth::User()->nama,

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
        $detail = DB::select("SELECT a.sub_no_po, a.tgl, sum(a.qty) as qty , sum(a.ttl_rp) as ttl_rp
        FROM pembelian_purchase as a
        where a.no_po = '$no_po'
        GROUP by a.sub_no_po;");
        $data = [
            'po' => $no_po,
            'purchase' => $detail,

        ];
        return view('pembelian_po.detail', $data);
    }

    public function detail_sub(Request $r)
    {
        $sub_po = $r->sub_po;
        $detail = DB::select("SELECT c.nm_bahan, d.nm_satuan, a.sub_no_po, a.tgl, a.qty, a.ttl_rp , a.h_satuan, a.admin
        FROM pembelian_purchase as a
        left join purchase as b on b.id_purchase = a.id_purchase
        left join tb_list_bahan as c on c.id_list_bahan = b.id_bahan
        left join tb_satuan as d on d.id_satuan = b.id_satuan_beli
        where a.sub_no_po = '$sub_po';");

        $data = [
            'detail' => $detail,
            'sub_po' => $sub_po
        ];
        return view('pembelian_po.detail_sub', $data);
    }

    public function print_pembelian(Request $r)
    {
        $sub_po = $r->sub_po;
        $detail = DB::select("SELECT c.nm_bahan, d.nm_satuan, a.sub_no_po, a.tgl, a.qty, a.ttl_rp , a.h_satuan, a.admin
        FROM pembelian_purchase as a
        left join purchase as b on b.id_purchase = a.id_purchase
        left join tb_list_bahan as c on c.id_list_bahan = b.id_bahan
        left join tb_satuan as d on d.id_satuan = b.id_satuan_beli
        where a.sub_no_po = '$sub_po';");

        $detail2 = DB::selectOne("SELECT c.nm_bahan, d.nm_satuan, a.sub_no_po, a.tgl, a.qty, a.ttl_rp , a.h_satuan, a.admin
        FROM pembelian_purchase as a
        left join purchase as b on b.id_purchase = a.id_purchase
        left join tb_list_bahan as c on c.id_list_bahan = b.id_bahan
        left join tb_satuan as d on d.id_satuan = b.id_satuan_beli
        where a.sub_no_po = '$sub_po';");

        $data = [
            'title' => 'Pembelian PO',
            'sub_po' => $sub_po,
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
