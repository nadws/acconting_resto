<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Buku_besar;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Gudang;
use App\Http\Controllers\Jurnal_pemasukan;
use App\Http\Controllers\Jurnal_pengeluaran;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

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
Route::get('/tambah_post', [AkunController::class, 'tambah_post'])->name('tambah_post');
Route::get('/delete_post', [AkunController::class, 'delete_post'])->name('delete_post');
Route::get('/loadEditkelompok', [AkunController::class, 'loadEditkelompok'])->name('loadEditkelompok');
Route::get('/edit_kelompok_baru', [AkunController::class, 'edit_kelompok_baru'])->name('edit_kelompok_baru');
Route::get('/loadEditAkun', [AkunController::class, 'loadEditAkun'])->name('loadEditAkun');


require __DIR__ . '/auth.php';
