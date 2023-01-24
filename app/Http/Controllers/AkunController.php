<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\KategoriAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkunController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Post Akun',
            'akun' => Akun::with('kategoriAkun')->get(),
            'no_akun' => 1,
            'kategori' => KategoriAkun::all(),
            'satuan' => DB::table('tb_satuan')->get()
        ];
        return view('akun.akun', $data);
    }

    public function save_akun(Request $r)
    {
        $data = [
            'no_akun' => $r->no_akun,
            'kd_akun' => $r->kd_akun,
            'nm_akun' => $r->nm_akun,
            'id_kategori' => $r->id_kategori,
            'id_penyesuaian' => !empty($r->id_penyesuaian) ? $r->id_penyesuaian : 0,
            'id_satuan' => empty($r->id_satuan) ? '0' : $r->id_satuan
        ];
        $akun = Akun::create($data);

        $id1 = $akun->id;

        if (!empty($r->id_penyesuaian)) {
            $nm_kelompok = $r->nm_kelompok;
            $umur = $r->umur;
            $satuan_aktiva = $r->satuan_aktiva;
            $tarif = $r->tarif;
            $barang = $r->barang;

            for ($x = 0; $x < count($nm_kelompok); $x++) {
                $t_tarif =  $tarif[$x] / 100;
                $data = [
                    'nm_kelompok' => $nm_kelompok[$x],
                    'umur' => $umur[$x],
                    'satuan' => $satuan_aktiva[$x],
                    'tarif' => $t_tarif,
                    'barang_kelompok' => $barang[$x],
                    'id_akun' => $id1
                ];
                DB::table('tb_kelompok_aktiva')->insert($data);
            }
        }

        if(!empty($r->no_akun2)) {
            $data = [
                'no_akun' => $r->no_akun2,
                'kd_akun' => $r->kd_akun2,
                'nm_akun' => $r->nm_akun2,
                'id_kategori' => $r->id_kategori2,

            ];
            $akun2 = Akun::create($data);
            $id2 = $akun2->id;

            $data = [
                'id_akun' => $id1,
                'id_relation_debit' => $id2,
                'id_relation_kredit' => $id1,
            ];

            DB::table('tb_relasi_akun')->insert($data);
        }

        $id_kategori = $r->id_kategori;

        if($id_kategori == 5) {
            $data = [
                'id_akun' => $id1,
                'id_sub_menu_akun' => 27
            ];
            DB::table('tb_permission_akun')->insert($data);
        } elseif($id_kategori == 4) {
            $data = [
                'id_akun' => $id1,
                'id_sub_menu_akun' => '26'
            ];
            DB::table('tb_permission_akun')->insert($data);
        }

        $id_biaya =  $r->id_biaya;
        $id_kas =  $r->id_kas;


        if ($id_kategori == '1') {
            if ($id_biaya == '1') {
                $data = [
                    'id_akun' => $id1,
                    'id_sub_menu_akun' => '30'
                ];
                DB::table('tb_permission_akun')->insert($data);
            }
            if ($id_kas == '1') {
                $data = [
                    'id_akun' => $id1,
                    'id_sub_menu_akun' => '28'
                ];
                DB::table('tb_permission_akun')->insert($data);
            }
        }

        return redirect()->route('akun')->with('sukses', 'Data Akun berhasil dibuat');
    }

    public function loadNoAkun(Request $r)
    {
        $no_akun = DB::selectOne("SELECT MAX(a.no_akun) AS no_max FROM tb_akun_fix AS a WHERE a.id_kategori = '$r->id_pilih'")->no_max;
        $max = empty($no_akun) ? $r->id_pilih . '001' : $max = $no_akun + 1;
        echo $max;
    }

    public function tambah_kelompok_aktiva(Request $r)
    {
        return view('akun.kelompok', ['count' => $r->c]);
    }

    public function del_akun($id)
    {
        $jurnal = DB::table('tb_jurnal')->where('id_akun', $id)->first();
        if (empty($jurnal)) {

            DB::table('tb_akun_fix')->where('id_akun', $id)->delete();
            DB::table('tb_permission_akun')->where('id_akun', $id)->delete();
            DB::table('tb_relasi_akun')->where('id_akun', $id)->delete();
            return redirect()->route("akun")->with('sukses', 'Data berhasil dihapus');
        } else {
            return redirect()->route("akun")->with('error', 'Data gagal dihapus');
        }
    }

    public function kelompok_akun(Request $r)
    {
        $data = [
            'aktiva' => DB::table('tb_kelompok_aktiva')->where('id_akun', $r->id_akun)->orderBy('id_kelompok', 'ASC')->get(),
            'id_akun' => $r->id_akun
        ];
        return view('akun.edit_kelompok', $data);
    }
    
    public function save_kelompok_baru(Request $r)
    {
        $nm_kelompok = $r->nm_kelompok;
        $umur = $r->umur;
        $satuan_aktiva = $r->satuan_aktiva;
        $tarif = $r->tarif;
        $barang = $r->barang;

        for ($x = 0; $x < count($nm_kelompok); $x++) {
            $t_tarif =  $tarif[$x] / 100;
            $data = [
                'nm_kelompok' => $nm_kelompok[$x],
                'umur' => $umur[$x],
                'satuan' => $satuan_aktiva[$x],
                'tarif' => $t_tarif,
                'barang_kelompok' => $barang[$x],
                'id_akun' => $r->id_akun
            ];
            DB::table('tb_kelompok_aktiva')->insert($data);
        }
    }

    public function post_center_akun(Request $r)
    {
        $id_akun = $r->id_akun;

        $data = [
            'post_center' => DB::select("SELECT * FROM tb_post_center as a where a.id_akun = '$id_akun'"),
            'id_akun' => $id_akun
        ];
        return view('akun.post_center', $data);
    }

    public function delete_kelompok_baru(Request $r)
    {
        DB::table('tb_kelompok_aktiva')->where('id_kelompok', $r->id_kelompok)->delete();
    }

    public function tambah_post(Request $request)
    {
        $data = [
            'nm_post' => $request->nm_post,
            'id_akun' => $request->id_akun,
        ];
        if(empty($request->id_post)) {
            DB::table('tb_post_center')->insert($data);
        } else {
            DB::table('tb_post_center')->where('id_post', $request->id_post)->update($data);
        }
    }

    public function delete_post(Request $r)
    {
        DB::table('tb_post_center')->where('id_post', $r->id_post)->delete();
        
    }

    public function loadEditkelompok(Request $r)
    {
        $data = [
            'aktiva' => DB::table('tb_kelompok_aktiva')->where('id_kelompok', $r->id_kelompok)->first(),
            'id_kelompok' => $r->id_kelompok
        ];
        return view('akun.editKelompokBaru', $data);
    }

    public function edit_kelompok_baru(Request $r)
    {
            $t_tarif =  $r->tarif / 100;
            $data = [
                'nm_kelompok' => $r->nm_kelompok,
                'umur' => $r->umur,
                'satuan' => $r->satuan_aktiva,
                'tarif' => $t_tarif,
                'barang_kelompok' => $r->barang,
            ];
            DB::table('tb_kelompok_aktiva')->where('id_kelompok', $r->id_kelompok)->update($data);
    }

    public function loadEditAkun(Request $r)
    {
        $data = [
            'akun' => DB::table('tb_akun_fix')->where('id_akun', $r->id_akun)->first(),
            'id_akun' => $r->id_akun
        ];
        return view('akun.load_edit_akun', $data);
    }
}
