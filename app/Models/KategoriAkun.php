<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAkun extends Model
{
    use HasFactory;
    protected $table = 'tb_kategori_akun_fix';
    protected $guarded = [];
}
