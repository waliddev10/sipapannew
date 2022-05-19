<?php

use App\Http\Controllers\PenandatanganController;
use Illuminate\Support\Facades\Artisan;
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

// setup

Route::get('/migrate', function () {
    return Artisan::call('migrate:fresh');
});
Route::get('/seed', function () {
    return Artisan::call('db:seed');
});
Route::get('/symlink', function () {
    $target =  env('SYMLINK_PATH');
    $shortcut = env('SYMLINK_PATH_TARGET');
    return symlink($target, $shortcut);
});

// router

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth'])->name('dashboard');




Route::get('/database/perusahaan', function () {
    return view('pages.database.perusahaan');
})->middleware(['auth'])->name('database.perusahaan');

Route::get('/database/masa-pajak', function () {
    return view('pages.database.masa-pajak');
})->middleware(['auth'])->name('database.masa-pajak');

Route::get('/database/tanggal-libur', function () {
    return view('pages.database.tanggal-libur');
})->middleware(['auth'])->name('database.tanggal-libur');


Route::middleware(['auth'])->group(function () {
    Route::prefix('setting')->group(function () {
        Route::resource('/penandatangan', PenandatanganController::class);
    });
});

Route::get('/setting/kota', function () {
    return view('pages.setting.kota');
})->middleware(['auth'])->name('setting.kota');



Route::get('/migrate', function () {
    return Artisan::call('migrate:fresh');
});

Route::get('/seed', function () {
    return Artisan::call('db:seed');
});

require __DIR__ . '/auth.php';
