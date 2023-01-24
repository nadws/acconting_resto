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
        Schema::create('tb_denda', function (Blueprint $table) {
            $table->integer('id_denda');
            $table->string('nama', 50);
            $table->string('alasan', 100);
            $table->integer('nominal');
            $table->date('tgl');
            $table->integer('id_lokasi');
            $table->string('admin', 50);
            $table->timestamps();
            $table->enum('import', ['T', 'Y']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_denda');
    }
};
