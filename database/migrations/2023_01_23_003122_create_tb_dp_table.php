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
        Schema::create('tb_dp', function (Blueprint $table) {
            $table->integer('id_dp', true);
            $table->string('kd_dp', 20);
            $table->string('nm_customer', 50);
            $table->string('server', 50);
            $table->integer('jumlah');
            $table->date('tgl');
            $table->string('ket', 50)->nullable();
            $table->string('metode', 50);
            $table->date('tgl_input');
            $table->date('tgl_digunakan');
            $table->tinyInteger('status');
            $table->string('admin', 50)->nullable();
            $table->integer('id_lokasi');
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
        Schema::dropIfExists('tb_dp');
    }
};
