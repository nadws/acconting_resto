<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'tb_akun_fix';
    protected $guarded = [];

    public function kategoriAkun()
    {
        return $this->belongsTo(KategoriAkun::class, 'id_kategori', 'id_kategori');
    }
}
