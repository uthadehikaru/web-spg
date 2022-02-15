<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyncController;
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

Route::middleware('auth')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/report', 'report')->name('report');
    });
    
    Route::get('/order', [ScanController::class,'index'])->name('order');
    Route::post('/order', [ScanController::class,'submit'])->name('order.submit');

    Route::get('/sync', [SyncController::class,'index'])->name('sync');
    Route::get('/sync/{order_no}', [SyncController::class,'sync'])->name('sync.process');
    Route::get('/sync/{order_no}/delete', [SyncController::class,'delete'])->name('sync.delete');
});
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'authenticate'])->name('login.authenticate');
