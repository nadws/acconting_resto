<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `view_menu` AS select `a`.`id_harga` AS `id_harga`,`a`.`id_menu` AS `id_menu`,`a`.`id_distribusi` AS `id_distribusi`,`a`.`harga` AS `harga`,`b`.`nm_menu` AS `nm_menu`,`c`.`nm_distribusi` AS `nm_distribusi`,`b`.`image` AS `image`,`b`.`aktif` AS `akv`,`b`.`tipe` AS `tipe`,`b`.`lokasi` AS `lokasi` from ((`lokalsdb`.`tb_harga` `a` left join `lokalsdb`.`tb_menu` `b` on(`a`.`id_menu` = `b`.`id_menu`)) left join `lokalsdb`.`tb_distribusi` `c` on(`a`.`id_distribusi` = `c`.`id_distribusi`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_menu`");
    }
};
