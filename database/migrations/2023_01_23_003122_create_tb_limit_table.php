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
        Schema::create('tb_limit', function (Blueprint $table) {
            $table->integer('id_limit');
            $table->integer('id_menu');
            $table->integer('id_lokasi');
            $table->integer('batas_limit');
            $table->integer('jml_limit');
            $table->string('admin', 50);
            $table->date('tgl');
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
        Schema::dropIfExists('tb_limit');
    }
};
