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
        Schema::create('ctt_driver', function (Blueprint $table) {
            $table->integer('id_driver');
            $table->string('no_order', 50);
            $table->string('nm_driver', 100);
            $table->double('nominal');
            $table->date('tgl');
            $table->string('admin', 100);
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
        Schema::dropIfExists('ctt_driver');
    }
};
