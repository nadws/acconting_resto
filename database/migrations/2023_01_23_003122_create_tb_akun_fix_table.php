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
        Schema::create('tb_akun_fix', function (Blueprint $table) {
            $table->integer('id_akun', true);
            $table->string('kd_akun', 100);
            $table->integer('no_akun');
            $table->string('nm_akun', 200);
            $table->integer('id_kategori');
            $table->integer('id_penyesuaian');
            $table->integer('id_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_akun_fix');
    }
};
