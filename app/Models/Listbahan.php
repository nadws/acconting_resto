<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listbahan extends Model
{
    use HasFactory;
    protected $table = 'tb_list_bahan';
    protected $fillable = [
        'nm_bahan', 'id_satuan', 'admin', 'tgl', 'id_lokasi', 'id_kategori_makanan', 'monitoring', 'jenis'
    ];
}
