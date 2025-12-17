<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\MoMoController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// ============ FRONTEND ROUTES ============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/category/{id}', [ProductController::class, 'category'])->name('products.category');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Checkout
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');
    Route::post('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('remove-coupon');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
});

// Orders (cần auth)
Route::middleware('auth')->prefix('orders')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/{id}/success', [OrderController::class, 'success'])->name('success');
    Route::get('/{id}/failed', [OrderController::class, 'failed'])->name('failed');
    Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// Order Tracking (không cần auth)
Route::get('/track-order', [OrderController::class, 'showTrackForm'])->name('order.track.form');
Route::post('/track-order', [OrderController::class, 'trackOrder'])->name('order.track.submit');

// MoMo Payment Routes
Route::get('/payment/momo/return', [MoMoController::class, 'return'])->name('momo.return');
Route::post('/payment/momo/notify', [MoMoController::class, 'notify'])->name('momo.notify');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google OAuth - Redirect
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
});

// Google OAuth - Callback (không cần middleware guest)
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============ ADMIN ROUTES ============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Products
    Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::post('/products/set-main-image/{id}', [AdminProductController::class, 'setMainImage'])->name('products.set-main-image');
    Route::resource('products', AdminProductController::class);

    // Orders
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{order}/update-payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::get('/orders/{order}/print', [AdminOrderController::class, 'print'])->name('orders.print');
    Route::get('/orders-export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);

    // Coupons
    Route::post('/coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    Route::resource('coupons', AdminCouponController::class);

    // Users
    Route::resource('users', AdminUserController::class);
});