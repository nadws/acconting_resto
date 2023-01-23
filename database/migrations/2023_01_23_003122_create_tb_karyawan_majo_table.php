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
        Schema::create('tb_karyawan_majo', function (Blueprint $table) {
            $table->integer('kd_karyawan');
            $table->string('id_karyawan', 50)->nullable();
            $table->string('nm_karyawan', 50)->nullable();
            $table->string('posisi', 50)->nullable();
            $table->string('pangkat', 50)->nullable();
            $table->double('gaji_e')->nullable();
            $table->double('gaji_m')->nullable();
            $table->double('gaji_sp')->nullable();
            $table->double('gaji_off')->nullable();
            $table->double('bonus')->nullable();
            $table->double('bonus_posisi')->nullable();
            $table->date('tgl_join');
            $table->date('tkmr')->nullable();
            $table->date('sdb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_karyawan_majo');
    }
};
