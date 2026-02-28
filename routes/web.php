<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\RemainderController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
