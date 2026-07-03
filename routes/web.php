<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MasterController::class, 'halamanlogin'])->name('HalamanLogin');
Route::post('/login', [MasterController::class, 'login'])->name('login');
Route::post('/logout', [MasterController::class, 'user_logout'])->name('Logout');
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [MasterController::class, 'dashboard'])->name('Dashboard');

    Route::get('/cabang', [MasterController::class, 'halamancabang'])->name('HalamanCabang');
    Route::post('/tambah_cabang', [MasterController::class, 'tambah_cabang'])->name('Tambah_Cabang');
    Route::post('/edit_cabang/{id}', [MasterController::class, 'edit_cabang'])->name('Edit_Cabang');
    Route::delete('/cabang/{cabang}', [MasterController::class, 'destroy'])->name('Cabang.destroy');

    Route::get('/vendor', [MasterController::class, 'halamanvendor'])->name('HalamanVendor');
    Route::post('/tambah_vendor', [MasterController::class, 'tambah_vendor'])->name('Tambah_Vendor');
    Route::post('/edit_vendor/{id}', [MasterController::class, 'edit_vendor'])->name('Edit_Vendor');
    Route::delete('/vendor/{vendor}', [MasterController::class, 'destroyVendor'])->name('Vendor.destroy');

    Route::get('/brand', [MasterController::class, 'halamanbrand'])->name('HalamanBrand');
    Route::post('/tambah_brand', [MasterController::class, 'tambah_brand'])->name('Tambah_Brand');
    Route::post('/edit_brand/{id}', [MasterController::class, 'edit_brand'])->name('Edit_Brand');
    Route::delete('/brand/{brand}', [MasterController::class, 'destroyBrand'])->name('Brand.destroy');

    Route::get('/unit', [MasterController::class, 'halamanunit'])->name('HalamanUnit');
    Route::post('/tambah_unit', [MasterController::class, 'tambah_unit'])->name('Tambah_Unit');
    Route::post('/edit_unit/{id}', [MasterController::class, 'edit_unit'])->name('Edit_Unit');
    Route::delete('/unit/{unit}', [MasterController::class, 'destroyUnit'])->name('Unit.destroy');

    Route::get('/kategori', [MasterController::class, 'halamankategori'])->name('HalamanKategori');
    Route::post('/tambah_kategori', [MasterController::class, 'tambah_kategori'])->name('Tambah_Kategori');
    Route::post('/edit_kategori/{id}', [MasterController::class, 'edit_kategori'])->name('Edit_Kategori');
    Route::delete('/kategori/{kategori}', [MasterController::class, 'destroyKategori'])->name('Kategori.destroy');

    Route::get('/jabatan', [MasterController::class, 'halamanjabatan'])->name('HalamanJabatan');
    Route::post('/tambah_jabatan', [MasterController::class, 'tambah_jabatan'])->name('Tambah_Jabatan');
    Route::post('/edit_jabatan/{id}', [MasterController::class, 'edit_jabatan'])->name('Edit_Jabatan');
    Route::delete('/jabatan/{jabatan}', [MasterController::class, 'destroyJabatan'])->name('Jabatan.destroy');

    Route::get('/item', [MasterController::class, 'halamanitem'])->name('HalamanItem');
    Route::post('/tambah_item', [MasterController::class, 'tambah_item'])->name('Tambah_Item');
    Route::post('/edit_item/{id}', [MasterController::class, 'edit_item'])->name('Edit_Item');
    Route::post('/edit_foto_item/{id}', [MasterController::class, 'edit_foto_item'])->name('Edit_Foto_Item');
    Route::delete('/item/{item}', [MasterController::class, 'destroyItem'])->name('Item.destroy');
    Route::delete('/item/detail-picture/{id}', [MasterController::class, 'deletePicture']);

    // setting
    // prefix
    Route::get('/prefix', [SettingController::class, 'halamanprefix'])->name('HalamanPrefix');
    Route::post('/edit_prefix/{id}', [SettingController::class, 'edit_prefix'])->name('Edit_Prefix');

    Route::get('/minstock', [SettingController::class, 'halamanmminstock'])->name('HalamanMinStock');
    // Route::get('/dminstock', [SettingController::class, 'halamandmminstock'])->name('HalamanDMinStock');
    Route::get('/stockopname', [SettingController::class, 'halamanstockopname'])->name('HalamanStockOpname');
    Route::get('/dstockopname/{id}', [SettingController::class, 'halamandstockopname'])->name('HalamandStockOpname');
    Route::post('/update_stock', [SettingController::class, 'update_stock'])->name('update_stock');
    Route::post('/update-stock-single', [SettingController::class, 'updateStockSingle']);
    Route::post('/import-stock', [SettingController::class, 'importStock'])->name('import.stock');
    Route::get('/download-template-stock/{id}', [SettingController::class, 'downloadTemplateStock'])
        ->name('download.template.stock');
});
