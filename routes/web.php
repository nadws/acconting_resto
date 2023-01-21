<?php

use App\Http\Controllers\Buku_besar;
use App\Http\Controllers\Gudang;
use App\Http\Controllers\Jurnal_pemasukan;
use App\Http\Controllers\Jurnal_pengeluaran;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::get('/', [Jurnal_pemasukan::class, 'index'])->name('jurnal_pemasukan');
Route::get('/data_pemasukan', [Jurnal_pemasukan::class, 'data_pemasukan'])->name('data_pemasukan');


Route::get('/jurnal_pengeluaran', [Jurnal_pengeluaran::class, 'index'])->name('jurnal_pengeluaran');
Route::get('/get_isi_jurnal', [Jurnal_pengeluaran::class, 'get_isi_jurnal'])->name('get_isi_jurnal');
Route::get('/get_satuan_bahan', [Jurnal_pengeluaran::class, 'get_satuan_bahan'])->name('get_satuan_bahan');
Route::get('/get_merk', [Jurnal_pengeluaran::class, 'get_merk'])->name('get_merk');
Route::get('/tambah_jurnal_daging', [Jurnal_pengeluaran::class, 'tambah_jurnal_daging'])->name('tambah_jurnal_daging');
Route::post('/save_stok_daging', [Jurnal_pengeluaran::class, 'save_stok_daging'])->name('save_stok_daging');

Route::get('/get_biaya_lain', [Jurnal_pengeluaran::class, 'get_biaya_lain'])->name('get_biaya_lain');
Route::get('/tambah_jurnal_lain', [Jurnal_pengeluaran::class, 'tambah_jurnal_lain'])->name('tambah_jurnal_lain');



Route::get('/gudang', [Gudang::class, 'index'])->name('gudang');
Route::get('/produk', [Gudang::class, 'produk'])->name('produk');
Route::get('/merk_bahan', [Gudang::class, 'merk_bahan'])->name('merk_bahan');
Route::get('/get_history_bahan', [Gudang::class, 'get_history_bahan'])->name('get_history_bahan');
Route::post('/save_opname', [Gudang::class, 'save_opname'])->name('save_opname');
Route::post('/save_bahan', [Gudang::class, 'save_bahan'])->name('save_bahan');
Route::post('/save_merk_bahan', [Gudang::class, 'save_merk_bahan'])->name('save_merk_bahan');

Route::get('/buku_besar', [Buku_besar::class, 'index'])->name('buku_besar');



require __DIR__ . '/auth.php';
