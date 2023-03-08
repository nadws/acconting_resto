<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionHalamanController extends Controller
{
    public function index()
    {
        if(in_array(auth()->user()->id, config('idBolehSet'))) {
            $data = [
                'title' => 'Permission Halaman',
                'permissionHalaman' => DB::table('permission_gudang')->get(),
                'permissionButton' => DB::table('permission_button_gudang as a')->join('permission_gudang as b', 'a.id_permission_gudang', 'b.id_permission')->get(),
            ];
            return view('permission_halaman.index',$data); 
        } else {
            abort(404);
        }
    }

    public function create(Request $r)
    {
        $id = DB::table('permission_gudang')->insertGetId([
            'nm_permission' => $r->nm_permission,
            'url' => $r->url,
        ]);

        for ($i=0; $i < count($r->nm_button); $i++) { 
            DB::table('permission_button_gudang')->insert([
                'id_permission_gudang' => $id,
                'nm_permission_button' => $r->nm_button[$i],
                'jenis' => $r->jenis[$i],
            ]);
        }

        return redirect()->route('permission_gudang.index')->with('sukses', 'Berhasil tambah data');
    }

    public function detail_permission($id)
    {
        $detail = DB::table('permission_button_gudang as a')->join('permission_gudang as b', 'a.id_permission_gudang', 'b.id_permission')->where('id_permission', $id)->get();
        
        return response()->json($detail);
    }
}
