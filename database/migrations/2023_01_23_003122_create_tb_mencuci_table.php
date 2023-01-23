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
        Schema::create('tb_mencuci', function (Blueprint $table) {
            $table->integer('id_mencuci');
            $table->string('nm_karyawan', 50);
            $table->integer('id_ket');
            $table->time('j_awal');
            $table->time('j_akhir');
            $table->date('tgl');
            $table->string('admin', 40);
            $table->timestamps();
            $table->enum('import', ['T', 'Y']);
            $table->string('ket2', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_mencuci');
    }
};
