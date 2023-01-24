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
        DB::statement("CREATE VIEW `view_nilai_masak2` AS select `koki_masak`.`id_order` AS `id_order`,`koki_masak`.`tgl` AS `tgl`,`koki_masak`.`no_order` AS `no_order`,`koki_masak`.`id_harga` AS `id_harga`,`koki_masak`.`id_lokasi` AS `id_lokasi`,`koki_masak`.`id_distribusi` AS `id_distribusi`,`koki_masak`.`qty` AS `qty`,`koki_masak`.`koki` AS `koki`,`koki_masak`.`lama_masak` AS `lama_masak`,`koki_masak`.`nilai_koki` AS `nilai_koki`,`koki_masak`.`jml_koki` AS `jml_koki`,`koki_masak`.`ket` AS `ket` from (select `view_nilai_masak`.`id_order` AS `id_order`,`view_nilai_masak`.`tgl` AS `tgl`,`view_nilai_masak`.`no_order` AS `no_order`,`view_nilai_masak`.`id_harga` AS `id_harga`,`view_nilai_masak`.`id_lokasi` AS `id_lokasi`,`view_nilai_masak`.`id_distribusi` AS `id_distribusi`,`view_nilai_masak`.`qty` AS `qty`,`view_nilai_masak`.`id_koki1` AS `koki`,`view_nilai_masak`.`lama_masak` AS `lama_masak`,`view_nilai_masak`.`nilai_koki` AS `nilai_koki`,`view_nilai_masak`.`jml_koki` AS `jml_koki`,'koki1' AS `ket` from `lokalsdb`.`view_nilai_masak` where `view_nilai_masak`.`id_koki1` > 0 union all select `view_nilai_masak`.`id_order` AS `id_order`,`view_nilai_masak`.`tgl` AS `tgl`,`view_nilai_masak`.`no_order` AS `no_order`,`view_nilai_masak`.`id_harga` AS `id_harga`,`view_nilai_masak`.`id_lokasi` AS `id_lokasi`,`view_nilai_masak`.`id_distribusi` AS `id_distribusi`,`view_nilai_masak`.`qty` AS `qty`,`view_nilai_masak`.`id_koki2` AS `koki`,`view_nilai_masak`.`lama_masak` AS `lama_masak`,`view_nilai_masak`.`nilai_koki` AS `nilai_koki`,`view_nilai_masak`.`jml_koki` AS `jml_koki`,'koki2' AS `ket` from `lokalsdb`.`view_nilai_masak` where `view_nilai_masak`.`id_koki2` > 0 union all select `view_nilai_masak`.`id_order` AS `id_order`,`view_nilai_masak`.`tgl` AS `tgl`,`view_nilai_masak`.`no_order` AS `no_order`,`view_nilai_masak`.`id_harga` AS `id_harga`,`view_nilai_masak`.`id_lokasi` AS `id_lokasi`,`view_nilai_masak`.`id_distribusi` AS `id_distribusi`,`view_nilai_masak`.`qty` AS `qty`,`view_nilai_masak`.`id_koki3` AS `koki`,`view_nilai_masak`.`lama_masak` AS `lama_masak`,`view_nilai_masak`.`nilai_koki` AS `nilai_koki`,`view_nilai_masak`.`jml_koki` AS `jml_koki`,'koki3' AS `ket` from `lokalsdb`.`view_nilai_masak` where `view_nilai_masak`.`id_koki3` > 0) `koki_masak` order by `koki_masak`.`id_order`,`koki_masak`.`ket`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_nilai_masak2`");
    }
};
