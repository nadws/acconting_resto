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
            abort(403, 'akses tidak ada');
        }
    }

    public function create(Request $r)
    {
        if(empty($r->detail)) {
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
        } else {
            for ($i=0; $i < count($r->nm_button_detail); $i++) { 
                DB::table('permission_button_gudang')->where('id_permission_button', $r->id_permission_button[$i])->update([
                    'id_permission_gudang' => $r->id_permission_gudang,
                    'nm_permission_button' => $r->nm_button_detail[$i],
                    'jenis' => $r->jenis[$i],
                ]);
            }

            if(!empty($r->tambah_row)) {
                for ($i=0; $i < count($r->nm_button_row); $i++) { 
                    DB::table('permission_button_gudang')->insert([
                        'id_permission_gudang' => $r->id_permission_gudang,
                        'nm_permission_button' => $r->nm_button_row[$i],
                        'jenis' => $r->jenis_row[$i],
                    ]);
                }
            }
        }

        return redirect()->route('permission_gudang.index')->with('sukses', 'Berhasil tambah data');
    }

    public function detail_permission($id)
    {
        $detail = DB::table('permission_button_gudang as a')->join('permission_gudang as b', 'a.id_permission_gudang', 'b.id_permission')->where('id_permission', $id)->get();
        
        return response()->json($detail);
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

        return redirect()->route(
            !empty($r->id) ? $r->route : 
            $r->route, $r->id
        )->with($pesan ?? 'error', "Permission " . strtoupper($pesan ?? 'error') . " di input");
    }
}
