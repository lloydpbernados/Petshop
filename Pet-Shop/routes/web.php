<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/admin/inventory', function () {
    return view('admin.inventory');
});
Route::get('/admin/supplies', function () {
    return view('admin.supplies');
});
Route::get('/admin/services', function () {
    return view('admin.services');
});
Route::get('/admin/inquiries', function () {
    return view('admin.messages');
});