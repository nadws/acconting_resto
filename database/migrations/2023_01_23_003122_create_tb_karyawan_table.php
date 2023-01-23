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
        Schema::create('tb_karyawan', function (Blueprint $table) {
            $table->integer('id_karyawan');
            $table->string('nama', 50);
            $table->integer('id_status');
            $table->date('tgl_masuk');
            $table->integer('id_posisi');
            $table->enum('point', ['T', 'Y']);
            $table->string('posisi', 100);
            $table->string('updated_at', 200);
            $table->string('created_at', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_karyawan');
    }
};
