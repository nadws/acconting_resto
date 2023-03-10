<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id_user = auth()->user()->id;

        $halaman = DB::selectOne("SELECT *
        FROM permission_perpage AS a
        WHERE a.id_user = '$id_user' AND a.id_permission_gudang ='1'
        GROUP BY a.id_permission_gudang");

        if (!empty($halaman)) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Halaman tidak tersedia'
        ], 404);



        return $next($request);
    }
}
