<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function index()
    {
        $id_lokasi = Session::get('id_lokasi');
        $id_user = auth()->user()->id;

        $data = [
            'title' => 'Kategori Bahan',
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', "$id_lokasi")->get(),
            
            'user' => User::whereIn('id_posisi', ['1', '2'])->get(),
            'halaman' => 9,
            // button

            'create' => btnHal(26,$id_user),

            'update' => btnHal(27,$id_user),
                            
            'delete' => btnHal(28,$id_user),
        ];
        return view('kategori.index', $data);
    }

    public function load_add_bahan(Request $r)
    {
        return view('kategori.load_add_bahan', [
            'bahan' => DB::table('tb_list_bahan')->where('id_lokasi', $id_lokasi ?? 1)->get(),
            'id_kategori' => $r->id_kategori
        ]);
    }

    public function save_add_bahan(Request $r)
    {
        if(!empty($r->id_list_bahan)) {
            DB::table('tb_bahan_kategori_makanan')->where('id_kategori', $r->id_kategori_makanan)->delete();

            for ($i=0; $i < count($r->id_list_bahan); $i++) { 
                DB::table('tb_list_bahan')->where('id_list_bahan', $r->id_list_bahan[$i])->update(['id_kategori_makanan' => $r->id_kategori_makanan]);

                DB::table('tb_bahan_kategori_makanan')->insert([
                    'id_list_bahan' => $r->id_list_bahan[$i],
                    'id_kategori' => $r->id_kategori_makanan,
                ]);
            }
            $pesan = 'sukses';
        }
        return redirect()->route('kategori_bahan')->with($pesan ?? 'error', ucwords($pesan ?? 'error') . "Tambah Bahan");

    }
}
