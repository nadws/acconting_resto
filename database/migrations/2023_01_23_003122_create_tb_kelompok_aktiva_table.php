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
        Schema::create('tb_kelompok_aktiva', function (Blueprint $table) {
            $table->integer('id_kelompok', true);
            $table->string('nm_kelompok', 50);
            $table->integer('umur');
            $table->integer('satuan');
            $table->double('tarif');
            $table->text('barang_kelompok');
            $table->integer('id_akun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_kelompok_aktiva');
    }
};
