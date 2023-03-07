<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Buku_besar;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Gudang;
use App\Http\Controllers\Jurnal_pemasukan;
use App\Http\Controllers\Jurnal_pengeluaran;
use App\Http\Controllers\OpnamePeralatanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Pembelian_purchase;
use App\Http\Controllers\PermissionHalamanController;
use App\Http\Controllers\Sistem_po;
use App\Http\Controllers\TimbangController;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::get('/jurnal_pemasukan', [Jurnal_pemasukan::class, 'index'])->name('jurnal_pemasukan');
    Route::get('/data_pemasukan', [Jurnal_pemasukan::class, 'data_pemasukan'])->name('data_pemasukan');

    Route::get('/jurnal_pengeluaran', [Jurnal_pengeluaran::class, 'index'])->name('jurnal_pengeluaran');
    Route::get('/get_isi_jurnal', [Jurnal_pengeluaran::class, 'get_isi_jurnal'])->name('get_isi_jurnal');
    Route::get('/get_satuan_bahan', [Jurnal_pengeluaran::class, 'get_satuan_bahan'])->name('get_satuan_bahan');
    Route::get('/get_merk', [Jurnal_pengeluaran::class, 'get_merk'])->name('get_merk');
    Route::get('/tambah_jurnal_daging', [Jurnal_pengeluaran::class, 'tambah_jurnal_daging'])->name('tambah_jurnal_daging');
    Route::post('/save_stok_daging', [Jurnal_pengeluaran::class, 'save_stok_daging'])->name('save_stok_daging');

    Route::get('/get_biaya_lain', [Jurnal_pengeluaran::class, 'get_biaya_lain'])->name('get_biaya_lain');
    Route::get('/tambah_jurnal_lain', [Jurnal_pengeluaran::class, 'tambah_jurnal_lain'])->name('tambah_jurnal_lain');

    Route::get('/edit_jurnal', [Jurnal_pengeluaran::class, 'edit_jurnal'])->name('edit_jurnal');
    Route::post('/edit_stok_daging', [Jurnal_pengeluaran::class, 'edit_stok_daging'])->name('edit_stok_daging');
    Route::get('/hapus_stok_daging', [Jurnal_pengeluaran::class, 'hapus_stok_daging'])->name('hapus_stok_daging');


    Route::get('/tambah_jurnal_biaya', [Jurnal_pengeluaran::class, 'tambah_jurnal_biaya'])->name('tambah_jurnal_biaya');
    Route::get('/get_save_jurnal', [Jurnal_pengeluaran::class, 'get_save_jurnal'])->name('get_save_jurnal');
    Route::post('/save_jurnal_biaya', [Jurnal_pengeluaran::class, 'save_jurnal_biaya'])->name('save_jurnal_biaya');
    Route::post('/save_jurnal_aktiva', [Jurnal_pengeluaran::class, 'save_jurnal_aktiva'])->name('save_jurnal_aktiva');
    Route::get('/tambah_jurnal_barang', [Jurnal_pengeluaran::class, 'tambah_jurnal_barang'])->name('tambah_jurnal_barang');

    Route::get('/get_post_aktiva', [Jurnal_pengeluaran::class, 'get_post_aktiva'])->name('get_post_aktiva');



    Route::get('/gudang', [Gudang::class, 'index'])->name('gudang');
    Route::get('/export_opname', [Gudang::class, 'export_opname'])->name('export_opname');
    Route::get('/produk/{id}', [Gudang::class, 'produk'])->name('produk');
    Route::get('/merk_bahan', [Gudang::class, 'merk_bahan'])->name('merk_bahan');
    Route::get('/hapusBahan/{id}/{id_jenis}', [Gudang::class, 'hapusBahan'])->name('hapusBahan');
    Route::get('/get_history_bahan', [Gudang::class, 'get_history_bahan'])->name('get_history_bahan');
    Route::post('/save_opname', [Gudang::class, 'save_opname'])->name('save_opname');
    Route::post('/save_bahan', [Gudang::class, 'save_bahan'])->name('save_bahan');
    Route::post('/save_merk_bahan', [Gudang::class, 'save_merk_bahan'])->name('save_merk_bahan');
    Route::post('/edit_bahan', [Gudang::class, 'edit_bahan'])->name('edit_bahan');
    Route::get('/loadEditBahan', [Gudang::class, 'loadEditBahan'])->name('loadEditBahan');
    Route::get('/kategoriMakanan/{id}', [Gudang::class, 'kategoriMakanan'])->name('kategoriMakanan');
    Route::post('/save_kategori_makanan', [Gudang::class, 'save_kategori_makanan'])->name('save_kategori_makanan');
    Route::post('/edit_kategori_makanan', [Gudang::class, 'edit_kategori_makanan'])->name('edit_kategori_makanan');
    Route::get('/hapus_kategori_makanan/{id}/{id_jenis}', [Gudang::class, 'hapus_kategori_makanan'])->name('hapus_kategori_makanan');
    Route::get('/get_merk', [Gudang::class, 'get_merk'])->name('get_merk');
    Route::get('/tambah_bahan', [Gudang::class, 'tambah_bahan'])->name('tambah_bahan');
    Route::get('/delete_bahan', [Gudang::class, 'delete_bahan'])->name('delete_bahan');

    Route::get('/buku_besar', [Buku_besar::class, 'index'])->name('buku_besar');
    Route::get('/detail_buku', [Buku_besar::class, 'detail_buku'])->name('detail_buku');


    Route::get('/user', [User::class, 'index'])->name('user');


    Route::get('/akun', [AkunController::class, 'index'])->name('akun');
    Route::post('/save_akun', [AkunController::class, 'save_akun'])->name('save_akun');
    Route::get('/loadNoAkun', [AkunController::class, 'loadNoAkun'])->name('loadNoAkun');
    Route::get('/tambah_kelompok_aktiva', [AkunController::class, 'tambah_kelompok_aktiva'])->name('tambah_kelompok_aktiva');
    Route::get('/del_akun/{id}', [AkunController::class, 'del_akun'])->name('del_akun');
    Route::get('/kelompok_akun', [AkunController::class, 'kelompok_akun'])->name('kelompok_akun');
    Route::get('/save_kelompok_baru', [AkunController::class, 'save_kelompok_baru'])->name('save_kelompok_baru');
    Route::get('/tambah_kelompok_aktiva', [AkunController::class, 'tambah_kelompok_aktiva'])->name('tambah_kelompok_aktiva');
    Route::get('/delete_kelompok_baru', [AkunController::class, 'delete_kelompok_baru'])->name('delete_kelompok_baru');
    Route::get('/post_center_akun', [AkunController::class, 'post_center_akun'])->name('post_center_akun');
    Route::get('/post_center_makanan', [AkunController::class, 'post_center_makanan'])->name('post_center_makanan');
    Route::get('/tambah_post', [AkunController::class, 'tambah_post'])->name('tambah_post');
    Route::get('/tambah_post_makanan', [AkunController::class, 'tambah_post_makanan'])->name('tambah_post_makanan');
    Route::get('/delete_post', [AkunController::class, 'delete_post'])->name('delete_post');
    Route::get('/loadEditkelompok', [AkunController::class, 'loadEditkelompok'])->name('loadEditkelompok');
    Route::get('/edit_kelompok_baru', [AkunController::class, 'edit_kelompok_baru'])->name('edit_kelompok_baru');
    Route::get('/loadEditAkun', [AkunController::class, 'loadEditAkun'])->name('loadEditAkun');
    Route::get('/get_kategori_kelompok', [AkunController::class, 'get_kategori_kelompok'])->name('get_kategori_kelompok');

    // cashflow
    Route::get('/cashflow', [CashflowController::class, 'index'])->name('cashflow');
    Route::get('/cashflloadTabelow', [CashflowController::class, 'loadTabel'])->name('loadTabel');
    Route::get('/loadSubKategori', [CashflowController::class, 'loadSubKategori'])->name('loadSubKategori');
    Route::get('/saveSubKategori', [CashflowController::class, 'saveSubKategori'])->name('saveSubKategori');
    Route::get('/editSubKategori', [CashflowController::class, 'editSubKategori'])->name('editSubKategori');
    Route::get('/deleteSubKategori', [CashflowController::class, 'deleteSubKategori'])->name('deleteSubKategori');
    Route::get('/loadAkunSubKategori', [CashflowController::class, 'loadAkunSubKategori'])->name('loadAkunSubKategori');
    Route::get('/saveAkunSubKategori', [CashflowController::class, 'saveAkunSubKategori'])->name('saveAkunSubKategori');
    Route::get('/loadDetailAkun', [CashflowController::class, 'loadDetailAkun'])->name('loadDetailAkun');

    Route::get('/sistem_po', [Sistem_po::class, 'index'])->name('sistem_po');
    Route::get('/tambah_po', [Sistem_po::class, 'tambah_po'])->name('tambah_po');
    Route::get('/tambah_baris_po', [Sistem_po::class, 'tambah_baris_po'])->name('tambah_baris_po');
    Route::post('/save_po', [Sistem_po::class, 'save_po'])->name('save_po');
    Route::get('/hrga_terakhir_po', [Sistem_po::class, 'hrga_terakhir_po'])->name('hrga_terakhir_po');
    Route::get('/satuan_terakhir_po', [Sistem_po::class, 'satuan_terakhir_po'])->name('satuan_terakhir_po');
    Route::get('/detail_po', [Sistem_po::class, 'detail_po'])->name('detail_po');
    Route::get('/print_po', [Sistem_po::class, 'print_po'])->name('print_po');
    Route::get('/edit_po', [Sistem_po::class, 'edit_po'])->name('edit_po');
    Route::get('/hapus_po', [Sistem_po::class, 'hapus_po'])->name('hapus_po');
    Route::post('/edit_save_po', [Sistem_po::class, 'edit_save_po'])->name('edit_save_po');

    Route::get('timbang', [TimbangController::class, 'index'])->name('timbang');
    Route::get('timbangDetail/{no_po}', [TimbangController::class, 'timbangDetail'])->name('timbangDetail');
    Route::get('timbangView/{no_po}', [TimbangController::class, 'timbangView'])->name('timbangView');
    Route::get('timbangEdit/{no_po}', [TimbangController::class, 'timbangEdit'])->name('timbangEdit');
    Route::post('save_timbang', [TimbangController::class, 'save_timbang'])->name('save_timbang');
    Route::get('detail_timbang', [TimbangController::class, 'detail_timbang'])->name('detail_timbang');
    Route::get('print_timbang', [TimbangController::class, 'print_timbang'])->name('print_timbang');

    Route::get('pembayaran', [PembayaranController::class, 'pembayaran'])->name('pembayaran');
    Route::get('pembayaran_bahan', [PembayaranController::class, 'pembayaran_bahan'])->name('pembayaran_bahan');
    Route::post('save_pembukuan', [PembayaranController::class, 'save_pembukuan'])->name('save_pembukuan');
    Route::get('cancel_pembukuan', [PembayaranController::class, 'cancel_pembukuan'])->name('cancel_pembukuan');
    Route::get('tambah_baris_pembyaran', [PembayaranController::class, 'tambah_baris_pembyaran'])->name('tambah_baris_pembyaran');

    Route::get('/pembelian_po', [Pembelian_purchase::class, 'index'])->name('pembelian_po');
    Route::get('/tambah_beli', [Pembelian_purchase::class, 'tambah_beli'])->name('tambah_beli');
    Route::post('/save_pembelian_po', [Pembelian_purchase::class, 'save_pembelian_po'])->name('save_pembelian_po');
    Route::get('/detail_po2', [Pembelian_purchase::class, 'detail_po2'])->name('detail_po2');
    Route::get('/print_pembelian', [Pembelian_purchase::class, 'print_pembelian'])->name('print_pembelian');
    Route::get('/edit_pembelian', [Pembelian_purchase::class, 'edit_pembelian'])->name('edit_pembelian');
    Route::post('/edit_save_pembelian_po', [Pembelian_purchase::class, 'edit_save_pembelian_po'])->name('edit_save_pembelian_po');
    Route::get('/print_timbangan', [TimbangController::class, 'print_nota'])->name('print_timbangan');
    Route::get('/tambah_pembayaran_dimuka', [Pembelian_purchase::class, 'tambah_pembayaran_dimuka'])->name('tambah_pembayaran_dimuka');
    Route::get('/tambah_pembayaran_dipasar', [Pembelian_purchase::class, 'tambah_pembayaran_dipasar'])->name('tambah_pembayaran_dipasar');
    Route::post('/save_pembelian_po_pasar', [Pembelian_purchase::class, 'save_pembelian_po_pasar'])->name('save_pembelian_po_pasar');
    Route::post('/save_pembelian_po_dimuka', [Pembelian_purchase::class, 'save_pembelian_po_dimuka'])->name('save_pembelian_po_dimuka');
    Route::get('/tambah_biaya_lain2', [Pembelian_purchase::class, 'tambah_biaya_lain2'])->name('tambah_biaya_lain2');
    Route::get('/tambah_biaya_lain3', [Pembelian_purchase::class, 'tambah_biaya_lain3'])->name('tambah_biaya_lain3');
    Route::get('/print_detail', [Pembelian_purchase::class, 'print_detail'])->name('print_detail');
    Route::get('/cancel_pembelian', [Pembelian_purchase::class, 'cancel_pembelian'])->name('cancel_pembelian');
    Route::get('/detail_sub', [Pembelian_purchase::class, 'detail_sub'])->name('detail_sub');

    // opname peralatan
    Route::get('/opname_peralatan', [OpnamePeralatanController::class, 'index'])->name('opname_peralatan');
    Route::post('/save_permission', [Sistem_po::class, 'save_permission'])->name('save_permission');
    Route::get('/load_pesanan', [Sistem_po::class, 'load_pesanan'])->name('load_pesanan');
    Route::get('/permission_gudang', [PermissionHalamanController::class, 'index'])->name('permission_gudang');
    Route::post('/permission_gudang', [PermissionHalamanController::class, 'create'])->name('permission_gudang.create');
    Route::get('/detail_permission/{id}', [PermissionHalamanController::class, 'detail_permission'])->name('detail_permission');
});


require __DIR__ . '/auth.php';
