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
        Schema::create('tb_relasi_akun', function (Blueprint $table) {
            $table->integer('id_relation', true);
            $table->integer('id_akun');
            $table->integer('id_relation_debit');
            $table->integer('id_relation_kredit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_relasi_akun');
    }
};
