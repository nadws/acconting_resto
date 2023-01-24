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
        DB::statement("CREATE VIEW `view_menu_kategori` AS select `a`.`id_menu` AS `id_menu`,`a`.`id_harga` AS `id_harga`,`b`.`nm_menu` AS `nm_menu`,`c`.`nm_distribusi` AS `nm_distribusi`,`a`.`harga` AS `harga`,`b`.`image` AS `image`,`a`.`id_distribusi` AS `id_distribusi`,`b`.`lokasi` AS `lokasi`,`b`.`id_kategori` AS `id_kategori` from ((`lokalsdb`.`tb_harga` `a` left join `lokalsdb`.`tb_menu` `b` on(`b`.`id_menu` = `a`.`id_menu`)) left join `lokalsdb`.`tb_distribusi` `c` on(`c`.`id_distribusi` = `a`.`id_distribusi`)) group by `a`.`id_harga`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_menu_kategori`");
    }
};
