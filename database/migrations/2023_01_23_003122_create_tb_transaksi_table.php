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
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->integer('id_transaksi', true);
            $table->date('tgl_transaksi');
            $table->string('no_order', 40);
            $table->double('total_orderan');
            $table->double('discount');
            $table->double('voucher')->default(0);
            $table->double('dp')->default(0);
            $table->double('gosen');
            $table->double('total_bayar');
            $table->string('admin', 20);
            $table->double('round');
            $table->integer('id_lokasi');
            $table->double('cash');
            $table->double('d_bca');
            $table->double('k_bca');
            $table->double('d_mandiri');
            $table->double('k_mandiri');
            $table->double('ongkir');
            $table->double('service');
            $table->double('tax');
            $table->timestamps();
            $table->enum('import', ['T', 'Y']);
            $table->integer('kembalian')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksi');
    }
};
