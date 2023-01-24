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
        Schema::create('tb_peringatan', function (Blueprint $table) {
            $table->integer('id_peringatan');
            $table->integer('id_lokasi');
            $table->time('jam_buat');
            $table->time('jam_akhir');
            $table->date('tgl');
            $table->string('admin', 100);
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
        Schema::dropIfExists('tb_peringatan');
    }
};
