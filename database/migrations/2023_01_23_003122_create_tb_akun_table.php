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
        Schema::create('tb_akun', function (Blueprint $table) {
            $table->integer('id_akun');
            $table->integer('id_lokasi');
            $table->string('kd_akun', 10);
            $table->string('no_akun', 20);
            $table->string('nm_akun', 50);
            $table->tinyInteger('id_kategori');
            $table->enum('pl', ['T', 'Y']);
            $table->enum('neraca', ['T', 'Y']);
            $table->enum('penyesuaian', ['T', 'Y']);
            $table->enum('neraca_saldo', ['T', 'Y']);
            $table->enum('penutup', ['T', 'Y']);
            $table->enum('ekuitas', ['T', 'Y']);
            $table->enum('aktiva_t', ['T', 'Y']);
            $table->enum('aktiva_l', ['T', 'Y']);
            $table->enum('pendapatan', ['T', 'Y']);
            $table->enum('pengeluaran', ['T', 'Y']);
            $table->enum('penutup_biaya', ['T', 'Y']);
            $table->enum('penutup_pendapatan', ['T', 'Y']);
            $table->timestamps();
            $table->enum('ppn_hutang', ['T', 'Y']);
            $table->enum('pendapatan_bank', ['T', 'Y']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_akun');
    }
};
