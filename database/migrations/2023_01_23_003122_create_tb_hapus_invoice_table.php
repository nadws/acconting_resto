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
        Schema::create('tb_hapus_invoice', function (Blueprint $table) {
            $table->integer('id_hapus_invoice');
            $table->string('no_order', 20);
            $table->date('tgl_order');
            $table->string('alasan', 100);
            $table->double('nominal_invoice');
            $table->integer('id_lokasi');
            $table->string('meja', 20);
            $table->string('admin', 20);
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
        Schema::dropIfExists('tb_hapus_invoice');
    }
};
