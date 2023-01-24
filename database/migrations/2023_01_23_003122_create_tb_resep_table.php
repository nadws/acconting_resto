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
        Schema::create('tb_resep', function (Blueprint $table) {
            $table->integer('id_resep', true);
            $table->integer('id_menu');
            $table->integer('id_list_bahan');
            $table->integer('id_satuan');
            $table->float('qty', 10, 0);
            $table->string('admin', 50);
            $table->date('tgl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_resep');
    }
};
