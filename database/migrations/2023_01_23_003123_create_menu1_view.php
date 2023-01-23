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
        DB::statement("CREATE VIEW `menu1` AS select `b`.`nm_menu` AS `nm_menu`,`c`.`nm_meja` AS `nm_meja`,`a`.`id_order` AS `id_order`,`a`.`no_order` AS `no_order`,`a`.`id_harga` AS `id_harga`,`a`.`qty` AS `qty`,`a`.`harga` AS `harga`,`a`.`request` AS `request`,`a`.`tambahan` AS `tambahan`,`a`.`page` AS `page`,`a`.`id_meja` AS `id_meja`,`a`.`selesai` AS `selesai`,`a`.`id_lokasi` AS `id_lokasi`,`a`.`pengantar` AS `pengantar`,`a`.`tgl` AS `tgl`,`a`.`admin` AS `admin`,`a`.`void` AS `void`,`a`.`round` AS `round`,`a`.`alasan` AS `alasan`,`a`.`nm_void` AS `nm_void`,`a`.`j_mulai` AS `j_mulai`,`a`.`j_selesai` AS `j_selesai`,`a`.`diskon` AS `diskon`,`a`.`wait` AS `wait`,`a`.`aktif` AS `aktif`,`a`.`id_koki1` AS `id_koki1`,`a`.`id_koki2` AS `id_koki2`,`a`.`id_koki3` AS `id_koki3`,`a`.`ongkir` AS `ongkir`,`a`.`id_distribusi` AS `id_distribusi`,`a`.`orang` AS `orang`,`a`.`no_checker` AS `no_checker`,`a`.`print` AS `print`,`a`.`copy_print` AS `copy_print`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,timestampdiff(MINUTE,`a`.`j_mulai`,`a`.`wait`) AS `selisih` from ((`lokalsdb`.`tb_order` `a` left join `lokalsdb`.`view_menu` `b` on(`b`.`id_harga` = `a`.`id_harga`)) left join `lokalsdb`.`tb_meja` `c` on(`c`.`id_meja` = `a`.`id_meja`)) where `a`.`selesai` <> 'selesai' and `a`.`aktif` = '1' and `a`.`void` = 0 order by `a`.`selesai` desc");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `menu1`");
    }
};
