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
        Schema::create('tb_sub_navbar', function (Blueprint $table) {
            $table->integer('id_sub_navbar');
            $table->integer('id_navbar');
            $table->string('sub_navbar', 100);
            $table->string('rot', 100);
            $table->string('img', 100);
            $table->integer('jen');
            $table->integer('urutan');
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
        Schema::dropIfExists('tb_sub_navbar');
    }
};
