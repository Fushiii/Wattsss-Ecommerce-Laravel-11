<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Default route to login view
Route::get('/', function () {
    return view('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('account.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('account.register');
Route::post('/register', [LoginController::class, 'processRegister'])->name('account.processRegister');
Route::post('/logout', [LoginController::class, 'logout'])->name('account.logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.view');

    // Cart routes
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{cart_id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.view'); // Use GET for viewing cart

    // Customer routes
    Route::middleware([CheckRole::class . ':customer'])->group(function () {
        Route::get('/customer', [DashboardController::class, 'customerDashboard'])->name('customer.dashboard');
        Route::get('/customer-shop', [ShopController::class, 'customerShop'])->name('customer.shop');
    });

    // Seller routes
    Route::middleware([CheckRole::class . ':seller'])->group(function () {
        Route::get('/seller', [DashboardController::class, 'sellerDashboard'])->name('seller.dashboard');
        Route::get('/seller-shop', [ShopController::class, 'sellerShop'])->name('seller.shop');
        Route::get('/seller-manage', [ProductController::class, 'index'])->name('manage.view');
        Route::post('/seller-manage', [ProductController::class, 'store'])->name('manage.store');
        Route::get('/seller-manage/{id}/edit', [ProductController::class, 'edit'])->name('manage.edit');
        Route::delete('/seller-manage/{id}', [ProductController::class, 'destroy'])->name('manage.destroy');
            
    });

    // Admin routes
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin-shop', [ShopController::class, 'adminShop'])->name('admin.shop');
        Route::get('/admin/applications', [ApplyController::class, 'index'])->name('admin.applications');
        Route::post('/admin/applications/{id}/approve', [ApplyController::class, 'approve'])->name('admin.approve');
        Route::post('/admin/applications/{id}/reject', [ApplyController::class, 'reject'])->name('admin.reject');
    });

    // Apply to be a seller
    Route::get('/apply-seller', [SellerApplicationController::class, 'showApplicationForm'])->name('applySeller');
    Route::post('/apply-seller', [SellerApplicationController::class, 'applySeller'])->name('applySeller.submit');

    // Checkout process route
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');
});
