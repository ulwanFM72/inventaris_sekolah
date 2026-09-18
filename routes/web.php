<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController as AdminInventarisController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Dapat diakses oleh siapa saja tanpa login. Hanya read-only.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/{inventaris}', [InventarisController::class, 'show'])->name('inventaris.show');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
| Halaman login admin (tidak boleh dilindungi middleware 'admin',
| karena admin belum login saat mengakses halaman ini).
*/

Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
| Seluruh route di dalam group ini dilindungi middleware 'admin',
| sehingga hanya user dengan is_admin = true yang dapat mengakses.
*/

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('inventaris', AdminInventarisController::class)
        ->except(['show'])
        ->parameters(['inventaris' => 'inventaris']);

    // Detail barang di sisi admin (dipisah agar tidak konflik nama route dengan public)
    Route::get('/inventaris/{inventaris}', [AdminInventarisController::class, 'show'])
        ->name('inventaris.show');
});