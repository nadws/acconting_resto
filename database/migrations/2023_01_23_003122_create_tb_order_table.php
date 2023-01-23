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
        Schema::create('tb_order', function (Blueprint $table) {
            $table->integer('id_order', true);
            $table->string('no_order', 20);
            $table->integer('id_harga');
            $table->double('qty');
            $table->double('harga');
            $table->string('request', 100)->nullable();
            $table->integer('tambahan');
            $table->integer('page');
            $table->integer('id_meja');
            $table->enum('selesai', ['dimasak', 'selesai', 'diantar']);
            $table->integer('id_lokasi');
            $table->string('pengantar', 100)->nullable();
            $table->date('tgl');
            $table->string('admin', 100);
            $table->integer('void');
            $table->double('round');
            $table->string('alasan', 40)->nullable();
            $table->string('nm_void', 100)->nullable();
            $table->dateTime('j_mulai');
            $table->dateTime('j_selesai');
            $table->double('diskon');
            $table->dateTime('wait');
            $table->integer('aktif');
            $table->integer('id_koki1');
            $table->integer('id_koki2');
            $table->integer('id_koki3');
            $table->double('ongkir');
            $table->integer('id_distribusi');
            $table->double('orang');
            $table->enum('no_checker', ['T', 'Y']);
            $table->enum('print', ['T', 'Y']);
            $table->enum('copy_print', ['T', 'Y']);
            $table->timestamps();
            $table->enum('import', ['T', 'Y']);
            $table->string('warna', 20);
            $table->enum('checker_tamu', ['T', 'Y']);
            $table->enum('copy_checkert_tamu', ['T', 'Y']);
            $table->enum('voucher', ['T', 'Y']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_order');
    }
};
