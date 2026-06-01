<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Customer\OrderTrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\GuestReplyController;
use App\Http\Controllers\SalesMonitoringController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Authentication ───────────────────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Registration (NEW) ───────────────────────────────────────────────────
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// ── Public / Storefront ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop',          [ShopController::class, 'index'])->name('shop');
Route::post('/shop/checkout', [ShopController::class, 'placeOrder'])->name('shop.checkout');
Route::get('/shop/success',   [ShopController::class, 'success'])->name('order.success');

// ── OTP Endpoints (no auth required — public) ────────────────────────────
Route::post('/shop/otp/send',   [ShopController::class, 'sendOtp'])->name('shop.otp.send');
Route::post('/shop/otp/verify', [ShopController::class, 'verifyOtp'])->name('shop.otp.verify');

// ── Order Tracking (Public) ──────────────────────────────────────────────
Route::get('/track',          [OrderTrackingController::class, 'form'])->name('order.track.form');
Route::post('/track/search',  [OrderTrackingController::class, 'search'])->name('order.track.search');
Route::post('/track/ajax',    [OrderTrackingController::class, 'ajaxSearch'])->name('order.track.ajax');
Route::get('/track/{number}', [OrderTrackingController::class, 'result'])->name('order.track.result');

// Contact form (both guest + auth)
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])
     ->name('contact.send');

// 3D Customizer
Route::get('/shop/3d', function () { return view('customer.3d-customizer'); })->name('shop.3d');

// Order history
Route::get('/shop/orders', function () { return view('customer.order-history'); })->name('shop.orders')->middleware('auth');

// Customer messaging (auth only)
Route::middleware('auth')->group(function () {
    Route::get('/api/my-messages',      [App\Http\Controllers\ContactController::class, 'myMessages'])
         ->name('my.messages');
    Route::post('/api/my-messages/send',[App\Http\Controllers\ContactController::class, 'myMessageSend'])
         ->name('my.messages.send');
});

// Guest reply page
Route::get('/guest-reply/{token}',  [App\Http\Controllers\GuestReplyController::class, 'show'])->name('guest.reply');
Route::post('/guest-reply/{token}', [App\Http\Controllers\GuestReplyController::class, 'send'])->name('guest.reply.send');

/*
|--------------------------------------------------------------------------
| Admin Routes (Secured — auth middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders',                   [AdminOrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{number}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/orders/export',            [AdminOrderController::class, 'exportCsv'])->name('orders.export');
    Route::patch('/orders/{number}/cancel', [AdminOrderController::class, 'cancelOrder'])->name('orders.cancel');
 
    // Sales Monitoring
    Route::get('/sales-monitoring',           [SalesMonitoringController::class, 'index'])->name('sales.monitoring');
    Route::get('/sales-monitoring/data',      [SalesMonitoringController::class, 'getData'])->name('sales.data');

    // Static Blade pages (data fetched via JS/API)
    Route::get('/inventory', fn() => view('admin.inventory'))->name('inventory');
    Route::get('/supplies',  fn() => view('admin.supplies'))->name('supplies');
    Route::get('/services',  fn() => view('admin.services'))->name('services');
    Route::get('/messages',  fn() => view('admin.messages'))->name('messages');

});