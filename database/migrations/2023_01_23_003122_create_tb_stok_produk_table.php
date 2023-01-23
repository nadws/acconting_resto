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
        Schema::create('tb_stok_produk', function (Blueprint $table) {
            $table->integer('id_stok_produk', true);
            $table->string('kode_stok_produk', 20);
            $table->integer('id_produk');
            $table->integer('stok_program');
            $table->integer('harga');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->integer('ttl_stok');
            $table->date('tgl');
            $table->dateTime('tgl_input');
            $table->string('ket', 100)->nullable();
            $table->string('admin', 70);
            $table->string('jenis', 50);
            $table->string('status', 20);
            $table->integer('id_lokasi')->nullable();
            $table->timestamps();
            $table->enum('import', ['T', 'Y']);
            $table->string('catatan', 200);
            $table->double('stok_aktual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_stok_produk');
    }
};
