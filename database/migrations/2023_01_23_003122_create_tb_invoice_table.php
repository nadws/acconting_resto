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
        Schema::create('tb_invoice', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('no_nota', 50);
            $table->integer('total');
            $table->integer('bayar');
            $table->integer('kembali');
            $table->integer('cash')->nullable();
            $table->integer('mandiri_kredit')->nullable();
            $table->integer('mandiri_debit')->nullable();
            $table->integer('bca_kredit')->nullable();
            $table->integer('bca_debit')->nullable();
            $table->integer('dp')->nullable();
            $table->string('kd_dp', 20)->nullable();
            $table->integer('diskon')->nullable();
            $table->date('tgl_jam');
            $table->dateTime('tgl_input')->nullable();
            $table->integer('id_customer')->nullable();
            $table->string('admin', 50);
            $table->string('no_meja', 20)->nullable();
            $table->string('lokasi', 20);
            $table->tinyInteger('status');
            $table->string('nm_void', 20);
            $table->string('ket_void', 50);
            $table->string('invoice', 100)->nullable();
            $table->timestamps();
            $table->integer('id_distribusi');
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
        Schema::dropIfExists('tb_invoice');
    }
};
