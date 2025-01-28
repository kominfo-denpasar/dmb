<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('front.beranda');

Route::get('/survei', [App\Http\Controllers\FrontController::class, 'surveiIntro'])->name('front.survei-intro');
Route::get('/survei/registrasi', [App\Http\Controllers\FrontController::class, 'surveiReg'])->name('front.survei-reg');
Route::post('/survei/dass-21', [App\Http\Controllers\FrontController::class, 'surveiDass'])->name('front.survei-dass-21');

Route::post('/survei/cek-nik', [App\Http\Controllers\FrontController::class, 'cekNik'])->name('front.cek-nik');
Route::post('/survei/store-reg', [App\Http\Controllers\FrontController::class, 'storeReg'])->name('front.store-reg');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('psikologs', App\Http\Controllers\PsikologController::class);
    Route::resource('masyarakats', App\Http\Controllers\MasyarakatController::class);
    Route::resource('dassPertanyaans', App\Http\Controllers\dassPertanyaanController::class);
});