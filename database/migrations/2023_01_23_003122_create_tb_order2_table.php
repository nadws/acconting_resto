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
        Schema::create('tb_order2', function (Blueprint $table) {
            $table->integer('id_order2', true);
            $table->integer('id_order1');
            $table->string('no_order', 30);
            $table->string('no_order2', 50);
            $table->integer('id_harga');
            $table->double('qty');
            $table->double('harga');
            $table->date('tgl');
            $table->integer('id_lokasi');
            $table->string('admin', 20);
            $table->integer('id_distribusi');
            $table->integer('id_meja');
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
        Schema::dropIfExists('tb_order2');
    }
};
