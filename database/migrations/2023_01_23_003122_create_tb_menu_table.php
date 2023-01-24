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
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->integer('id_menu', true);
            $table->integer('id_kategori');
            $table->integer('kd_menu');
            $table->string('nm_menu', 120);
            $table->enum('tipe', ['food', 'drink']);
            $table->string('jenis', 20);
            $table->tinyInteger('lokasi');
            $table->string('image', 100);
            $table->enum('aktif', ['on', 'off']);
            $table->date('tgl_sold')->nullable();
            $table->timestamps();
            $table->integer('id_handicap')->nullable();
            $table->integer('id_station');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_menu');
    }
};
