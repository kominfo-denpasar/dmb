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

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('front.beranda');

Route::get('/survei', [App\Http\Controllers\FrontController::class, 'surveiIntro'])->name('front.survei-intro');
Route::get('/survei/registrasi', [App\Http\Controllers\FrontController::class, 'surveiReg'])->name('front.survei-reg');
Route::get('/survei/dass-21', [App\Http\Controllers\FrontController::class, 'surveiDass'])->name('front.survei-dass-21');
Route::get('/survei/hasil', [App\Http\Controllers\FrontController::class, 'surveiHasil'])->name('front.survei-hasil');
Route::get('/konseling/registrasi', [App\Http\Controllers\FrontController::class, 'konselingReg'])->name('front.konseling-reg');
Route::get('/konseling/keluhan/{id}', [App\Http\Controllers\FrontController::class, 'konselingKeluhan'])->name('front.konseling-keluhan');
Route::get('/konseling/jadwal/{id}', [App\Http\Controllers\FrontController::class, 'konselingJadwal'])->name('front.konseling-jadwal');
Route::get('/konseling/final/{id}', [App\Http\Controllers\FrontController::class, 'konselingFinal'])->name('front.konseling-final');

Route::post('/survei/cek-nik', [App\Http\Controllers\FrontController::class, 'cekNik'])->name('front.cek-nik');
Route::post('/survei/store-reg', [App\Http\Controllers\FrontController::class, 'storeReg'])->name('front.store-reg');
Route::post('/survei/store-dass', [App\Http\Controllers\FrontController::class, 'storeDass'])->name('front.store-dass');
Route::post('/konseling/store-keluhan', [App\Http\Controllers\FrontController::class, 'konselingKeluhanStore'])->name('front.konseling-keluhan-store');
Route::post('/konseling/store-jadwal', [App\Http\Controllers\FrontController::class, 'konselingJadwalStore'])->name('front.konseling-jadwal-store');

Route::get('/konseling/store-reg/{id}', [App\Http\Controllers\FrontController::class, 'konselingStoreReg'])->name('front.konseling-store-reg');
Route::post('/validasi-otp', [App\Http\Controllers\FrontController::class, 'validasiOtp'])->name('front.validasi-otp');

Route::get('/jadwal/psikolog/{id}', [App\Http\Controllers\FrontController::class, 'jadwalPsikolog'])->name('front.jadwal-psikolog');

Route::get('/evaluasi/{id}/{keluhan}', [App\Http\Controllers\FrontController::class, 'formulirEvaluasi'])->name('front.evaluasi');
Route::post('/evaluasi/store', [App\Http\Controllers\FrontController::class, 'storeEvaluasi'])->name('front.store-evaluasi');

Route::get('/faq', [App\Http\Controllers\FrontController::class, 'faq'])->name('faq');
Route::get('/privasi', [App\Http\Controllers\FrontController::class, 'privasi'])->name('privasi');

Route::get('/artikel/{slug}', [App\Http\Controllers\FrontController::class, 'blogDetail'])->name('front.blog-detail');
Route::get('/artikel', [App\Http\Controllers\FrontController::class, 'blogList'])->name('front.blog-list');

Auth::routes();

Route::group([
    'middleware' => ['auth', 'web']
    ], 
    function () {
    Route::prefix('admin')->group(function () {

        Route::get('/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('backend.profil');
        Route::patch('/profil/update/{id}', [App\Http\Controllers\HomeController::class, 'updateProfil'])->name('backend.update-profil');
        Route::patch('/profil/admin/{id}', [App\Http\Controllers\HomeController::class, 'updateProfilAdmin'])->name('backend.update-profil-admin');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // dashboard
        Route::get('/dashboard/data', [App\Http\Controllers\HomeController::class, 'data']);

        Route::prefix('home-psikolog')->group(function () {
            Route::get('/', [App\Http\Controllers\HomePsikologController::class, 'index'])->name('home-psikolog');
            Route::get('/konseling/{id}', [App\Http\Controllers\HomePsikologController::class, 'konseling'])->name('backend.konseling');
            Route::get('/konseling/{id}/laporan-detail', [App\Http\Controllers\HomePsikologController::class, 'laporanDetail'])->name('backend.laporan-detail');
            Route::get('/konseling/{id}/pdf', [App\Http\Controllers\HomePsikologController::class, 'printPdf'])->name('konseling.pdf');

            Route::get('/konseling/evaluasi/{id}/{keluhan}', [App\Http\Controllers\HomePsikologController::class, 'formEvaluasi'])->name('backend.evaluasi');

            Route::get('/konseling/batal/{id}', [App\Http\Controllers\HomePsikologController::class, 'batal'])->name('backend.konseling-batal');
            Route::post('/konseling/reschedule', [App\Http\Controllers\HomePsikologController::class, 'reschedule'])->name('backend.konseling-reschedule');

            Route::post('/konseling/jadwal', [App\Http\Controllers\HomePsikologController::class, 'storeJadwal'])->name('backend.storeJadwal');
            Route::post('/konseling/jadwal/update', [App\Http\Controllers\HomePsikologController::class, 'updateJadwal'])->name('backend.updateJadwal');

            Route::post('/konseling/hasil', [App\Http\Controllers\HomePsikologController::class, 'storeHasil'])->name('backend.storeHasil');
            Route::post('/konseling/hasil/{id}', [App\Http\Controllers\HomePsikologController::class, 'updateHasil'])->name('backend.updateHasil');
        });
        
        Route::prefix('master')->group(function () {
            Route::get('psikologs/json', [App\Http\Controllers\PsikologController::class, 'indexJson'])->name('backend.psikolog-json');
            Route::get('psikologs/keluhan-json/{id}', [App\Http\Controllers\PsikologController::class, 'keluhanJson'])->name('backend.psikolog-keluhan-json');
            Route::get('konselings/masyarakat-json/{mas_id}', [App\Http\Controllers\KonselingController::class, 'masyarakatJson'])->name('backend.masyarakat-json');

            Route::get('/konseling/details/{id}', [App\Http\Controllers\KonselingController::class, 'konselingDetails'])->name('konseling.details');
            
            Route::resource('psikologs', App\Http\Controllers\PsikologController::class);
            Route::resource('masyarakats', App\Http\Controllers\MasyarakatController::class);
            Route::resource('dassPertanyaans', App\Http\Controllers\dassPertanyaanController::class);
            Route::resource('dasshasils', App\Http\Controllers\dasshasilController::class);
            Route::resource('keluhans', App\Http\Controllers\keluhanController::class);
            Route::resource('masalahs', App\Http\Controllers\MasalahController::class);
            Route::resource('konselings', App\Http\Controllers\KonselingController::class);
            Route::resource('konseling-masalahs', App\Http\Controllers\KonselingMasalahController::class);

        });

        Route::prefix('data')->group(function () {
            Route::get('blogs/json', [App\Http\Controllers\BlogController::class, 'indexJson'])->name('backend.blog-json');
            Route::resource('blogs', App\Http\Controllers\BlogController::class);
            Route::resource('blog-kategoris', App\Http\Controllers\BlogKategoriController::class);
        });

        Route::resource('pengaturans', App\Http\Controllers\PengaturanController::class);
        Route::resource('jadwals', App\Http\Controllers\jadwalController::class);
        Route::resource('evaluasis', App\Http\Controllers\EvaluasiController::class);
        Route::resource('logs', App\Http\Controllers\LogController::class);

    });
});


Route::get('/test', [App\Http\Controllers\FrontController::class, 'testHalaman']);
Route::get('/notif', [App\Http\Controllers\FrontController::class, 'testNotif']);

Route::get('/error', function () {
    throw new Exception('My first GlitchTip error!');
});




// Route::any('{catchall}', [App\Http\Controllers\FrontController::class, 'notFound'])->where('catchall', '.*');