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
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\KandangController as UserKandangController;
use App\Http\Controllers\User\AyamController as UserAyamController;
use App\Http\Controllers\User\ProduksiController as UserProduksiController;
use App\Http\Controllers\User\KesehatanController as UserKesehatanController;
use App\Http\Controllers\User\KonsumsiController as UserKonsumsiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
     if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
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

Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/kandang', [UserKandangController::class, 'index'])->name('kandang.index');
    Route::get('/kandang/{kandang}', [UserKandangController::class, 'show'])->name('kandang.show');

    Route::get('/ayam', [UserAyamController::class, 'index'])->name('ayam.index');
    Route::get('/ayam/{ayam}', [UserAyamController::class, 'show'])->name('ayam.show');

    // Produksi (Create Only)
    Route::get('/produksi', [UserProduksiController::class, 'index'])->name('produksi.index');
    Route::get('/produksi/create', [UserProduksiController::class, 'create'])->name('produksi.create');
    Route::post('/produksi', [UserProduksiController::class, 'store'])->name('produksi.store');
    Route::get('/produksi/{produksi}', [UserProduksiController::class, 'show'])->name('produksi.show');

    // Kesehatan (Create Only)
    Route::get('/kesehatan', [UserKesehatanController::class, 'index'])->name('kesehatan.index');
    Route::get('/kesehatan/create', [UserKesehatanController::class, 'create'])->name('kesehatan.create');
    Route::post('/kesehatan', [UserKesehatanController::class, 'store'])->name('kesehatan.store');
    Route::get('/kesehatan/{kesehatan}', [UserKesehatanController::class, 'show'])->name('kesehatan.show');

    // Konsumsi (Create Only)
    Route::get('/konsumsi', [UserKonsumsiController::class, 'index'])->name('konsumsi.index');
    Route::get('/konsumsi/create', [UserKonsumsiController::class, 'create'])->name('konsumsi.create');
    Route::post('/konsumsi', [UserKonsumsiController::class, 'store'])->name('konsumsi.store');
    Route::get('/konsumsi/{konsumsi}', [UserKonsumsiController::class, 'show'])->name('konsumsi.show');
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
