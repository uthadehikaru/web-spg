<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ApiController;
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
    });
    
    Route::get('/order', [ScanController::class,'index'])->name('order');
    Route::post('/order', [ScanController::class,'submit'])->name('order.submit');
    Route::get('/order/{order:order_no}/edit', [ScanController::class,'edit'])->name('order.edit');
    Route::post('/order/{order:order_no}/edit', [ScanController::class,'update'])->name('order.update');
    Route::get('/order/{order_no}/delete', [SyncController::class,'delete'])->name('order.delete');
    Route::get('/order/{order:order_no}/cancel', [ReportController::class,'cancel'])->name('order.cancel');
    Route::get('/order/{order:order_no}', [ReportController::class,'detail'])->name('order.detail');

    Route::get('/report', [ReportController::class,'index'])->name('report');

    Route::get('/sync', [SyncController::class,'index'])->name('sync');
    Route::get('/sync/create', [SyncController::class,'sync'])->name('sync.create');
    Route::get('/sync/{order:order_no}/cancel', [SyncController::class,'cancel'])->name('sync.cancel');
    
    Route::get('/users', [UserController::class,'index'])->name('user');
    Route::get('/users/sync', [UserController::class,'sync'])->name('user.sync');

    Route::get('/products', [ProductController::class,'index'])->name('product');
    Route::get('/products/sync', [ProductController::class,'sync'])->name('product.sync');
    
    Route::get('/api/product/{product:value}', [ApiController::class,'product'])->name('api.product');
    
    Route::get('/logout', [LoginController::class,'logout'])->name('logout');
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'authenticate'])->name('login.authenticate');
