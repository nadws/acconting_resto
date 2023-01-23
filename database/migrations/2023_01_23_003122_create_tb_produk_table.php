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
        Schema::create('tb_produk', function (Blueprint $table) {
            $table->integer('id_produk', true);
            $table->integer('id_kategori');
            $table->integer('id_satuan');
            $table->string('sku', 50)->nullable();
            $table->string('nm_produk', 100);
            $table->float('harga_modal', 10, 0)->nullable();
            $table->float('harga', 10, 0);
            $table->integer('stok');
            $table->integer('terjual')->nullable();
            $table->text('foto')->nullable();
            $table->float('diskon', 10, 0)->nullable();
            $table->double('komisi');
            $table->enum('monitoring', ['y', 't']);
            $table->integer('id_lokasi')->nullable();
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
        Schema::dropIfExists('tb_produk');
    }
};
