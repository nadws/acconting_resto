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
        DB::statement("CREATE VIEW `view_summary_server` AS select `a`.`id_order` AS `id_order`,`a`.`tgl` AS `tgl`,`a`.`no_order` AS `no_order`,`a`.`admin` AS `admin`,`a`.`id_koki1` AS `id_koki1`,`a`.`id_koki2` AS `id_koki2`,`a`.`id_koki3` AS `id_koki3`,`a`.`id_lokasi` AS `id_lokasi`,sum(`a`.`harga`) AS `hrg`,`a`.`voucher` AS `voucher` from `lokalsdb`.`tb_order` `a` where `a`.`id_distribusi` <> '2' group by `a`.`no_order`,`a`.`admin`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_summary_server`");
    }
};
