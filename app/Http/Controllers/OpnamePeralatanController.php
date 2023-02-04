<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpnamePeralatanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Opname Peralatan'
        ];
        return view('opname_peralatan.opname',$data);
    }
}
