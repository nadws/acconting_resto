<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bk', function (Blueprint $table) {
            $table->integer('id_bk');
            $table->integer('id_kategori_bk');
            $table->string('kode_bk', 50);
            $table->string('nm_bk', 100);
            $table->integer('hrg_stn_beli');
            $table->string('satuan_beli', 20);
            $table->integer('qty_beli');
            $table->string('satuan_aktual', 10);
            $table->integer('susut');
            $table->integer('modal');
            $table->integer('stok');
            $table->enum('monitoring', ['Y', 'T', '', '']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_bk');
    }
};
