<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'User',
            'user' => DB::table('users')->where('jenis', 'adm')->get()
        ];
        return view('user.index', $data);
    }
}
