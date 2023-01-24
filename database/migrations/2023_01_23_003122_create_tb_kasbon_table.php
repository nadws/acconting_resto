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
        Schema::create('tb_kasbon', function (Blueprint $table) {
            $table->integer('id_kasbon');
            $table->string('nm_karyawan', 50);
            $table->double('nominal');
            $table->date('tgl');
            $table->string('admin', 50);
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
        Schema::dropIfExists('tb_kasbon');
    }
};
