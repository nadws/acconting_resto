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
        Schema::create('tb_discount', function (Blueprint $table) {
            $table->integer('id_discount');
            $table->integer('disc');
            $table->text('ket');
            $table->string('jenis', 10)->nullable();
            $table->date('dari')->nullable();
            $table->date('expired');
            $table->enum('status', ['0', '1', '', '']);
            $table->string('lokasi', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_discount');
    }
};
