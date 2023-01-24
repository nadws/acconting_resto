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
        Schema::create('tb_distribusi', function (Blueprint $table) {
            $table->integer('id_distribusi');
            $table->string('nm_distribusi', 20);
            $table->enum('service', ['Y', 'T']);
            $table->enum('ongkir', ['Y', 'T']);
            $table->enum('tax', ['T', 'Y']);
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
        Schema::dropIfExists('tb_distribusi');
    }
};
