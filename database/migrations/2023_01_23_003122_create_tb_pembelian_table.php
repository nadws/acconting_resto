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
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->integer('id_pembelian', true);
            $table->string('no_nota', 20);
            $table->string('no_nota2', 50);
            $table->integer('id_karyawan')->nullable();
            $table->integer('id_produk');
            $table->string('nm_karyawan', 50)->nullable();
            $table->date('tanggal');
            $table->dateTime('tgl_input')->nullable();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('diskon')->nullable();
            $table->double('jml_komisi');
            $table->integer('total');
            $table->text('catatan')->nullable();
            $table->string('admin', 50);
            $table->string('no_meja', 20)->nullable();
            $table->string('lokasi', 20);
            $table->tinyInteger('void');
            $table->timestamps();
            $table->string('pengantar', 100);
            $table->enum('selesai', ['diantar', 'selesai']);
            $table->enum('bayar', ['T', 'Y']);
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
        Schema::dropIfExists('tb_pembelian');
    }
};
