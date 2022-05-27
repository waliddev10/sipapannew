<?php

use App\Http\Controllers\Database\MasaPajakController;
use App\Http\Controllers\Database\PerusahaanController;
use App\Http\Controllers\Database\TanggalLiburController;
use App\Http\Controllers\Ketentuan\CaraPelaporanController;
use App\Http\Controllers\Ketentuan\JenisUsahaController;
use App\Http\Controllers\Ketentuan\NpaController;
use App\Http\Controllers\Ketentuan\SanksiAdministrasiController;
use App\Http\Controllers\Ketentuan\SanksiBungaController;
use App\Http\Controllers\Ketentuan\TarifPajakController;
use App\Http\Controllers\Penatausahaan\PelaporanController;
use App\Http\Controllers\Setting\KotaPenandatanganController;
use App\Http\Controllers\Setting\PenandatanganController;
use App\Models\MasaPajak;
use App\Models\Perusahaan;
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
    return Artisan::call('migrate');
});
Route::get('/migrate/fresh', function () {
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
    // return view('welcome');
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $perusahaan_count = Perusahaan::all()->count();
        $masa_pajak_count = MasaPajak::all()->count();
        return view('pages.dashboard', compact('perusahaan_count', 'masa_pajak_count'));
    })->name('dashboard');

    Route::prefix('/penatausahaan')->group(function () {
        Route::resource('/pelaporan', PelaporanController::class);
        Route::get('/cetak-pelaporan/{pelaporan}', [PelaporanController::class, 'print'])
            ->name('pelaporan.cetak-surat');
        Route::get('/berkas-pelaporan/{filename}', [PelaporanController::class, 'showFile'])
            ->name('pelaporan.berkas');
    });

    Route::prefix('/database')->group(function () {
        Route::resource('/tanggal-libur', TanggalLiburController::class);
        Route::resource('/masa-pajak', MasaPajakController::class);
        Route::resource('/perusahaan', PerusahaanController::class);
    });
    Route::prefix('/ketentuan')->group(function () {
        Route::resource('/jenis-usaha', JenisUsahaController::class);
        Route::resource('/cara-pelaporan', CaraPelaporanController::class);
        Route::resource('/tarif-pajak', TarifPajakController::class);
        Route::resource('/npa', NpaController::class);
        Route::resource('/sanksi-administrasi', SanksiAdministrasiController::class);
        Route::resource('/sanksi-bunga', SanksiBungaController::class);
    });
    Route::prefix('/setting')->group(function () {
        Route::resource('/penandatangan', PenandatanganController::class);
        Route::resource('/kota-penandatangan', KotaPenandatanganController::class);
    });
});

require __DIR__ . '/auth.php';
