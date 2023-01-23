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
        DB::statement("CREATE VIEW `view_nilai_masak` AS select `lokalsdb`.`tb_order`.`id_order` AS `id_order`,`lokalsdb`.`tb_order`.`tgl` AS `tgl`,`lokalsdb`.`tb_order`.`no_order` AS `no_order`,`lokalsdb`.`tb_order`.`id_harga` AS `id_harga`,`lokalsdb`.`tb_order`.`id_lokasi` AS `id_lokasi`,`lokalsdb`.`tb_order`.`id_distribusi` AS `id_distribusi`,`lokalsdb`.`tb_order`.`qty` AS `qty`,`lokalsdb`.`tb_order`.`id_koki1` AS `id_koki1`,`lokalsdb`.`tb_order`.`id_koki2` AS `id_koki2`,`lokalsdb`.`tb_order`.`id_koki3` AS `id_koki3`,timestampdiff(MINUTE,`lokalsdb`.`tb_order`.`j_mulai`,`lokalsdb`.`tb_order`.`j_selesai`) AS `lama_masak`,if(`lokalsdb`.`tb_order`.`id_koki1` > 0 and `lokalsdb`.`tb_order`.`id_koki2` > 0 and `lokalsdb`.`tb_order`.`id_koki3` > 0,`lokalsdb`.`tb_order`.`qty` / 3,if(`lokalsdb`.`tb_order`.`id_koki1` > 0 and `lokalsdb`.`tb_order`.`id_koki2` > 0,`lokalsdb`.`tb_order`.`qty` / 2,`lokalsdb`.`tb_order`.`qty`)) AS `nilai_koki`,if(`lokalsdb`.`tb_order`.`id_koki1` > 0 and `lokalsdb`.`tb_order`.`id_koki2` > 0 and `lokalsdb`.`tb_order`.`id_koki3` > 0,3,if(`lokalsdb`.`tb_order`.`id_koki1` > 0 and `lokalsdb`.`tb_order`.`id_koki2` > 0,2,1)) AS `jml_koki`,`c`.`tipe` AS `tipe` from ((`lokalsdb`.`tb_order` left join `lokalsdb`.`tb_harga` `b` on(`b`.`id_harga` = `lokalsdb`.`tb_order`.`id_harga`)) left join `lokalsdb`.`tb_menu` `c` on(`c`.`id_menu` = `b`.`id_menu`)) where `lokalsdb`.`tb_order`.`void` = 0 and `lokalsdb`.`tb_order`.`aktif` = 2 and `c`.`tipe` = 'food'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_nilai_masak`");
    }
};
