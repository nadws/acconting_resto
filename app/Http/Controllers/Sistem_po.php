<?php

namespace App\Http\Controllers;

use App\Models\Listbahan;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Sistem_po extends Controller
{

    public function index(Request $r)
    {
        $cekP = DB::table('permission_gudang')->where('url', $r->route()->getName())->first();
        $cek = DB::table('permission_perpage')->where([['id_user', auth()->user()->id], ['id_permission_gudang', $cekP->id_permission]])->first();
        if(empty($cek)) {
            return abort(403);
        }
   

        $id_lokasi = Session::get('id_lokasi');
        $id_user = Auth::user()->id;

        $cekP = DB::table('permission_gudang')->where('url', $r->route()->getName())->first();
        $cek = DB::table('permission_perpage')->where([['id_user', $id_user], ['id_permission_gudang', $cekP->id_permission]])->first();
        if (empty($cek)) {
            return abort(404);
        }
        $data = [
            'title' => 'Purchase Order (PO)',
            'halaman' => '1',
            'purchase' => DB::select("SELECT a.tgl, a.no_po, a.admin, sum(a.ttl_rp) as total, a.beli FROM purchase as a 
            where a.id_lokasi = '$id_lokasi'
            group by a.no_po order by a.id_purchase DESC"),
            'user' => User::whereIn('id_posisi', ['1', '2'])->get(),
            'idBolehSet' => config('idBolehSet'),

            // button

            'tambah' => DB::selectOne("SELECT * FROM permission_perpage as a left join permission_button_gudang as b on b.id_permission_button = a.id_permission_button where a.id_permission_button = '1' and a.id_user = '$id_user'"),

            'print' => DB::selectOne("SELECT * FROM permission_perpage as a left join permission_button_gudang as b on b.id_permission_button = a.id_permission_button where a.id_permission_button = '2' and a.id_user = '$id_user'"),

            'edit' => DB::selectOne("SELECT * FROM permission_perpage as a left join permission_button_gudang as b on b.id_permission_button = a.id_permission_button where a.id_permission_button = '3' and a.id_user = '$id_user'"),

            'hapus' => DB::selectOne("SELECT * FROM permission_perpage as a left join permission_button_gudang as b on b.id_permission_button = a.id_permission_button where a.id_permission_button = '4' and a.id_user = '$id_user'"),

        ];
        return view('sistem_po.index', $data);
    }

    public function save_permission(Request $r)
    {
        $id_user = $r->id_user;
        $id_permission_gudang = $r->id_permission_gudang;
        DB::table('permission_perpage')->where('id_permission_gudang', $id_permission_gudang)->delete();

        if (!empty($id_user)) {
            for ($i = 0; $i < count($id_user); $i++) {
                $id_permission = "id_permission" . $id_user[$i];
                $id_permission = $r->$id_permission;

                foreach ($id_permission as $b => $d) {
                    $data = [
                        'id_permission_button' => $d,
                        'id_user' => $id_user[$i],
                        'id_permission_gudang' => $id_permission_gudang
                    ];
                    DB::table('permission_perpage')->insert($data);
                }
            }
            $pesan = 'sukses';
        }

        return redirect()->route("sistem_po")->with($pesan ?? 'error', "Permission " . strtoupper($pesan ?? 'error') . " di input");
    }

    public function tambah_po(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $max = DB::selectOne("SELECT max(a.urutan) as max_urutan FROM purchase as a where a.id_lokasi = '$id_lokasi'");

        if (empty($max->max_urutan)) {
            $no_po = '1001';
        } else {
            $no_po = $max->max_urutan + 1;
        }
        if ($id_lokasi == '1') {
            $kode = 'T';
        } else {
            $kode = 'S';
        }
        $data = [
            'title' => 'Tambah Pengajuan Pembelian PO',
            'list_bahan' => Listbahan::whereMonitoringAndId_lokasi('Y', $id_lokasi)->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'kode' => $kode,
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', $id_lokasi)->get()
        ];
        return view('sistem_po.tambah', $data);
    }

    public function tambah_baris_po(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $data = [
            'title' => 'Tambah Pengajuan Pembelian',
            'list_bahan' => Listbahan::whereMonitoringAndId_lokasi('Y', $id_lokasi)->get(),
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
        $id_lokasi = Session::get('id_lokasi');
        $max = DB::selectOne("SELECT max(a.urutan) as max_urutan FROM purchase as a where a.id_lokasi = '$id_lokasi'");

        if (empty($max->max_urutan)) {
            $no_po = '1001';
        } else {
            $no_po = $max->max_urutan + 1;
        }

        if ($id_lokasi == '1') {
            $kode = 'T';
        } else {
            $kode = 'S';
        }


        for ($x = 0; $x < count($id_bahan); $x++) {
            $data = [
                'tgl' => $tgl,
                'no_po' => 'PO' . $kode . $no_po,
                'ket' => $ket,
                'id_bahan' => $id_bahan[$x],
                'qty' => $qty[$x],
                'id_satuan_beli' => $id_satuan[$x],
                'rp_satuan' => $h_satuan[$x],
                'ttl_rp' => $ttl_rp[$x],
                'admin' => Auth::user()->nama,
                'urutan' => $no_po,
                'id_lokasi' => Session::get('id_lokasi')
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
                'admin' => Session::get('username'),
                'urutan' => $urutan,
                'id_lokasi' => Session::get('id_lokasi')
            ];
            DB::table('purchase')->insert($data);
        }
        return redirect()->route("sistem_po")->with('sukses', 'Data berhasil di input');
    }

    public function hrga_terakhir_po(Request $r)
    {
        $id_bahan = $r->id_bahan;
        $max = DB::selectOne("SELECT  max(a.id_purchase) as max_id FROM purchase as a where a.id_bahan = '$id_bahan'");

        $bahan = DB::selectOne("SELECT a.h_satuan FROM pembelian_purchase as a where a.id_purchase = '$max->max_id'");

        if (empty($bahan)) {
            $rupiah =  0;
        } else {
            $rupiah = $bahan->h_satuan;
        }



        $data = [
            'rupiah' => $rupiah,
        ];

        echo json_encode($data);
    }

    public function satuan_terakhir_po(Request $r)
    {
        $id_bahan = $r->id_bahan;
        $max = DB::selectOne("SELECT  max(a.id_purchase) as max_id FROM purchase as a where a.id_bahan = '$id_bahan'");
        $bahan = DB::selectOne("SELECT a.h_satuan FROM pembelian_purchase as a where a.id_purchase = '$max->max_id'");
        $po = DB::selectOne("SELECT a.id_satuan_beli FROM purchase as a where a.id_purchase = '$max->max_id'");
        $satuan = Satuan::all();



        if (empty($po->id_satuan_beli)) {
            $id_satuan = 0;
        } else {
            $id_satuan = $po->id_satuan_beli;
        }
        foreach ($satuan as $s) {
            if ($s->id_satuan == $id_satuan) {
                echo "<option value='$s->id_satuan'  selected>$s->nm_satuan</option>";
            } else {
                echo "<option value='$s->id_satuan'  >$s->nm_satuan</option>";
            }
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
        $detail = DB::select("SELECT a.id_purchase, a.tgl, b.id_list_bahan, a.id_satuan_beli, a.no_po, a.urutan, a.ket, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");
        $detail2 = DB::selectOne("SELECT a.id_purchase, b.id_list_bahan, a.admin, a.tgl, a.urutan,a.ket, a.no_po, b.nm_bahan, c.nm_satuan, a.qty, a.rp_satuan, a.ttl_rp FROM purchase as a
        left join tb_list_bahan as b on b.id_list_bahan = a.id_bahan
        left join tb_satuan as c on c.id_satuan = a.id_satuan_beli
        where a.no_po = '$no_po'");

        $data = [
            'title' => 'Edit Pengajuan Pembelian',
            'list_bahan' => Listbahan::whereMonitoring('Y')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'detail' => $detail,
            'detail2' => $detail2
        ];
        return view('sistem_po.edit_po', $data);
    }

    public function hapus_po(Request $r)
    {
        DB::table('purchase')->where('no_po', $r->no_po)->delete();
        return redirect()->route("sistem_po")->with('sukses', 'Data berhasil di hapus');
    }

    public function load_pesanan(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $max = DB::selectOne("SELECT max(a.urutan) as max_urutan FROM purchase as a where a.id_lokasi = '$id_lokasi'");

        if (empty($max->max_urutan)) {
            $no_po = '1001';
        } else {
            $no_po = $max->max_urutan + 1;
        }
        if ($id_lokasi == '1') {
            $kode = 'T';
        } else {
            $kode = 'S';
        }
        $id_kategori = $r->id_kategori;
        $data = [
            'title' => 'Tambah Pengajuan Pembelian PO',
            'list_bahan' => Listbahan::where(['monitoring' => 'Y', 'id_lokasi' => $id_lokasi, 'id_kategori_makanan' => $id_kategori])->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'no_po' => $no_po,
            'kode' => $kode,
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', $id_lokasi)->get()
        ];
        return view('sistem_po.load_pesanan', $data);
    }
}
