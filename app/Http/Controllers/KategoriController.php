<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function index(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');

        $data = [
            'title' => 'Kategori Bahan',
            'kategori' => DB::table('tb_kategori_makanan')->where('id_lokasi', "$id_lokasi")->get()
        ];
        return view('kategori.index', $data);
    }
}
