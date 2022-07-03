<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/beranda', 'App\Http\Controllers\HomeController@index')->name('home');

    Route::resource('karyawan', 'App\Http\Controllers\UserController');
    Route::get('/apiKaryawan', 'App\Http\Controllers\UserController@apiKaryawan')->name('api.karyawan');

    Route::resource('pelanggan', 'App\Http\Controllers\PelangganController');
    Route::get('/apiPelanggan', 'App\Http\Controllers\PelangganController@apiPelanggan')->name('api.pelanggan');

    Route::resource('kategorijasa', 'App\Http\Controllers\KategoriJasaController');
    Route::get('/apiKategoriJasa', 'App\Http\Controllers\KategoriJasaController@apiKategoriJasa')->name('api.kategorijasa');

    Route::resource('servisorder', 'App\Http\Controllers\ServisOrderController');
    Route::get('/apiServisOrder', 'App\Http\Controllers\ServisOrderController@apiServisOrder')->name('api.servisorder');

    Route::resource('tugasteknisi', 'App\Http\Controllers\TugasTeknisiController');
    Route::get('/apiTugasTeknisi', 'App\Http\Controllers\TugasTeknisiController@apiTugasTeknisi')->name('api.tugasteknisi');
    Route::get('/laporantugasteknisi', 'App\Http\Controllers\TugasTeknisiController@laporanTugasTeknisi');
    Route::get('/apiLaporanTugasTeknisi', 'App\Http\Controllers\TugasTeknisiController@apiLaporanTugasTeknisi')->name('api.laporantugasteknisi');
    Route::get('/exportLaporanTugasTeknisi', 'App\Http\Controllers\TugasTeknisiController@exportLaporanTugasTeknisi')->name('exportPDF.laporanTugasTeknisi');

    Route::resource('daftartugas', 'App\Http\Controllers\DaftarTugasController');
    Route::get('/apiDaftarTugas', 'App\Http\Controllers\DaftarTugasController@apiDaftarTugas')->name('api.daftartugas');
    Route::get('/daftartugasselesai', 'App\Http\Controllers\DaftarTugasController@daftarTugasSelesai');
    Route::get('/apiDaftarTugasSelesai', 'App\Http\Controllers\DaftarTugasController@apiDaftarTugasSelesai')->name('api.daftartugasselesai');
});