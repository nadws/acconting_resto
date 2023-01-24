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
        Schema::create('tb_jurnal', function (Blueprint $table) {
            $table->integer('id_jurnal', true);
            $table->integer('id_buku');
            $table->integer('id_post')->nullable();
            $table->integer('id_akun');
            $table->integer('id_post_center')->nullable();
            $table->string('kd_gabungan', 20);
            $table->string('no_nota', 20)->nullable();
            $table->integer('id_lokasi');
            $table->string('jenis', 100);
            $table->string('no_urutan', 50)->nullable();
            $table->integer('urutan');
            $table->double('debit')->nullable();
            $table->double('kredit')->nullable();
            $table->string('no_bkin', 50)->nullable();
            $table->integer('id_produk')->nullable();
            $table->integer('qty')->nullable();
            $table->smallInteger('id_satuan')->nullable();
            $table->integer('rp_beli')->nullable();
            $table->integer('ttl_rp')->nullable();
            $table->integer('rp_pajak')->nullable();
            $table->date('tgl');
            $table->dateTime('tgl_input')->nullable();
            $table->string('ket', 50)->nullable();
            $table->string('ket2', 100)->nullable();
            $table->string('admin', 20)->nullable();
            $table->enum('status', ['Y', 'T']);
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
        Schema::dropIfExists('tb_jurnal');
    }
};
