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
        Schema::create('tb_gaji', function (Blueprint $table) {
            $table->integer('id_gaji');
            $table->integer('id_karyawan');
            $table->integer('rp_e');
            $table->integer('rp_m');
            $table->integer('rp_sp');
            $table->integer('g_bulanan');
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
        Schema::dropIfExists('tb_gaji');
    }
};
