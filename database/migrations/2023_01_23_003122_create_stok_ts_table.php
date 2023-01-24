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
        Schema::create('stok_ts', function (Blueprint $table) {
            $table->integer('id_stok_ts', true);
            $table->integer('id_bahan');
            $table->integer('id_satuan');
            $table->double('debit');
            $table->double('kredit');
            $table->date('tgl');
            $table->string('admin', 30)->nullable();
            $table->string('no_nota', 50);
            $table->enum('opname', ['T', 'Y']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_ts');
    }
};
