<?php

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
    $target = env('SYMLINK_PATH_TARGET');
    $shortcut = env('SYMLINK_PATH');
    return symlink($target, $shortcut);
});


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





Route::get('/migrate', function () {
    return Artisan::call('migrate:fresh');
});

Route::get('/seed', function () {
    return Artisan::call('db:seed');
});

require __DIR__ . '/auth.php';
