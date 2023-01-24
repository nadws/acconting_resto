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
        Schema::create('tb_merk_bahan', function (Blueprint $table) {
            $table->integer('id_merk_bahan', true);
            $table->integer('id_list_bahan');
            $table->string('nm_merk', 100);
            $table->integer('id_lokasi');
            $table->string('admin', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_merk_bahan');
    }
};
