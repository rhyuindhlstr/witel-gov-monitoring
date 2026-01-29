<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeGSController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PeluangProyekGSController;
use App\Http\Controllers\AktivitasMarketingController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// LANDING PAGE
Route::get('/', function () {
    return view('welcome');
});

// AUTH (LOGIN, LOGOUT, DLL) - BAWAAN LARAVEL
Auth::routes();

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------
    | HOME / DASHBOARD
    |--------------------------------------------------
    */
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/dashboard-gs', [HomeGSController::class, 'index'])
        ->name('dashboard.gs');

    /*
    |--------------------------------------------------
    | WILAYAH (MASTER DATA)
    |--------------------------------------------------
    */
    Route::resource('wilayah', WilayahController::class);

    /*
    |--------------------------------------------------
    | PELUANG PROYEK GS
    |--------------------------------------------------
    */
    Route::resource('peluang-gs', PeluangProyekGSController::class);

    // EXPORT PELUANG GS (CSV / EXCEL)
    Route::get(
        'peluang-gs/export',
        [PeluangProyekGSController::class, 'export']
    )->name('peluang-gs.export');

    /*
|--------------------------------------------------------------------------
| AKTIVITAS MARKETING
|--------------------------------------------------------------------------
*/
Route::resource(
    'aktivitas-marketing',
    AktivitasMarketingController::class
);

Route::get(
    'peluang-gs/{peluang_g}/pdf',
    [PeluangProyekGSController::class, 'exportPdf']
)->name('peluang-gs.pdf');


});
