<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
// 1. ADD THIS LINE: Import the ShopController
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/inventory', function () {
        return view('admin.inventory');
    });

    Route::get('/supplies', function () {
        return view('admin.supplies');
    });

    Route::get('/services', function () {
        return view('admin.services');
    });

    // Fixed: Now matches /admin/orders
    Route::get('/orders', function () {
        return view('admin.orders'); 
    });

    Route::get('/inquiries', function () {
        return view('admin.messages');
    });

});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->group(function () {
    
    // 2. UPDATED: Points to ShopController index method
    Route::get('/shop', [ShopController::class, 'index'])->name('customer.shop');

});