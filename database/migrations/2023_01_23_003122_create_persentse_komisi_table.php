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
        Schema::create('persentse_komisi', function (Blueprint $table) {
            $table->integer('id_persentase');
            $table->string('nama_persentase', 30);
            $table->integer('jumlah_persen');
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
        Schema::dropIfExists('persentse_komisi');
    }
};
