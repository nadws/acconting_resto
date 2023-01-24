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
        Schema::create('tb_list_bahan', function (Blueprint $table) {
            $table->integer('id_list_bahan', true);
            $table->string('nm_bahan', 100);
            $table->integer('id_satuan');
            $table->string('admin', 100);
            $table->date('tgl');
            $table->integer('id_lokasi');
            $table->integer('id_kategori_makanan');
            $table->timestamps();
            $table->enum('monitoring', ['T', 'Y']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_list_bahan');
    }
};
