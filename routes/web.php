<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\RemainderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') return redirect()->route('dashboard');
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/teknisi-dashboard', [DashboardController::class, 'teknisi'])
    ->middleware('auth')
    ->name('teknisi.dashboard');

Route::get('/staff-dashboard', [DashboardController::class, 'staff'])
    ->middleware('auth')
    ->name('staff.dashboard');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::post('/barang/insert', [BarangController::class, 'insert'])->name('barang.insert');
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');
Route::match(['put', 'patch'], '/barang/update/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/delete/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user/insert', [UserController::class, 'insert'])->name('user.insert');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::match(['put', 'patch'], '/user/update/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
Route::post('/maintenance/insert', [MaintenanceController::class, 'insert'])->name('maintenance.insert');
Route::get('/maintenance/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenance.show');
Route::match(['put', 'patch'], '/maintenance/update/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenance.update');
Route::delete('/maintenance/delete/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');

Route::get('/perbaikan', [PerbaikanController::class, 'index'])->name('perbaikan.index');
Route::post('/perbaikan/insert', [PerbaikanController::class, 'insert'])->name('perbaikan.insert');
Route::get('/perbaikan/{perbaikan}', [PerbaikanController::class, 'show'])->name('perbaikan.show');
Route::match(['put', 'patch'], '/perbaikan/update/{perbaikan}', [PerbaikanController::class, 'update'])->name('perbaikan.update');
Route::delete('/perbaikan/delete/{perbaikan}', [PerbaikanController::class, 'destroy'])->name('perbaikan.destroy');

Route::get('/remainder', [RemainderController::class, 'index'])->name('remainder.index');
Route::post('/remainder/insert', [RemainderController::class, 'insert'])->name('remainder.insert');
Route::get('/remainder/{remainder}', [RemainderController::class, 'show'])->name('remainder.show');
Route::match(['put', 'patch'], '/remainder/update/{remainder}', [RemainderController::class, 'update'])->name('remainder.update');
Route::delete('/remainder/delete/{remainder}', [RemainderController::class, 'destroy'])->name('remainder.destroy');

Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
Route::post('/vendor/insert', [VendorController::class, 'insert'])->name('vendor.insert');
Route::get('/vendor/{vendor}', [VendorController::class, 'show'])->name('vendor.show');
Route::match(['put', 'patch'], '/vendor/update/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
Route::delete('/vendor/delete/{vendor}', [VendorController::class, 'destroy'])->name('vendor.destroy');

// Fallback file serving for storage if symlink isn't accessible (prevents 403)
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    if (! file_exists($fullPath)) {
        abort(404);
    }
    return Response::file($fullPath);
})->where('path', '.*');

// Alternate public endpoint to ALWAYS proxy files through Laravel, avoiding static server 403
Route::get('/files/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    if (! file_exists($fullPath)) {
        abort(404);
    }
    return Response::file($fullPath);
})->where('path', '.*');
