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
        Schema::create('tb_sold_out', function (Blueprint $table) {
            $table->integer('id_sold_out');
            $table->date('tgl');
            $table->integer('id_menu');
            $table->integer('id_lokasi');
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
        Schema::dropIfExists('tb_sold_out');
    }
};
