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
        Schema::create('tb_voucher', function (Blueprint $table) {
            $table->integer('id_voucher');
            $table->integer('jumlah');
            $table->text('ket');
            $table->date('expired');
            $table->enum('status', ['0', '1', '', '']);
            $table->string('lokasi', 50);
            $table->timestamps();
            $table->string('kode', 10);
            $table->string('terpakai', 30)->nullable();
            $table->string('admin', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_voucher');
    }
};
