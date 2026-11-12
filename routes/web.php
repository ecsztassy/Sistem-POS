<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect()->route(auth()->user()->role === 'admin' ? 'dashboard' : 'pos.index') : redirect()->route('login'));
Route::middleware('auth')->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/items', [PosController::class, 'search'])->name('pos.items');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/receipt/{transaction}', [PosController::class, 'receipt'])->name('pos.receipt');
    Route::get('/pos/receipt/{transaction}/pdf', [PosController::class, 'pdf'])->name('pos.receipt.pdf');
    Route::get('/sales/daily', [PosController::class, 'daily'])->name('sales.daily');
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::resource('categories', CategoryController::class)->only('index', 'store', 'update', 'destroy');
        Route::get('/items/data', [ItemController::class, 'data'])->name('items.data');
        Route::resource('items', ItemController::class)->except('show');
        Route::resource('users', UserController::class)->except('show');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
        Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
        Route::get('/settings', [StoreSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [StoreSettingController::class, 'update'])->name('settings.update');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
require __DIR__.'/auth.php';
