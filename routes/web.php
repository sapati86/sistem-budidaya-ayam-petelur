<?php

use App\Http\Controllers\Admin\AyamController;
use App\Http\Controllers\Admin\KandangController;
use App\Http\Controllers\Admin\KesehatanAyamController;
use App\Http\Controllers\Admin\KonsumsiPakanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PakanController;
use App\Http\Controllers\Admin\ProduksiTelurController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','2fa'])->name('dashboard');

Route::middleware(['auth', 'verified', '2fa'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    
    Route::resource('kandang', KandangController::class);
    Route::resource('ayam', AyamController::class);
    Route::resource('kesehatan', KesehatanAyamController::class);
    Route::resource('pakan', PakanController::class);
    Route::resource('produksi', ProduksiTelurController::class);
    Route::resource('konsumsi', KonsumsiPakanController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'showSetup'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
});

Route::get('/2fa/verify', [TwoFactorController::class, 'showVerify'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');

require __DIR__.'/auth.php';
