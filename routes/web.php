<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\Web\Admin\AdminDashboardController;
use App\Http\Controllers\Web\Admin\DataPadiController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\Web\Admin\PaymentController;
use App\Http\Controllers\Web\Admin\ProductController;
use App\Http\Controllers\Web\Admin\UserManagementController;
use App\Http\Controllers\Web\Pembeli\ProductListController;
use App\Http\Middleware\UserAkses;
use Illuminate\Support\Facades\Route;



Route::get('/cek-midtrans-key', function () {
    return env('MIDTRANS_SERVER_KEY');
});

Route::middleware(['guest'])->group(function(){
    // Login
    Route::get('/login', [AuthController::class, 'index'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard Umum (semua yang login bisa akses)
    Route::get('/', [AdminDashboardController::class, 'index'])->name('show.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('show.dashboard');

    // Superadmin Only
    Route::middleware('userAkses:superadmin')->group(function () {
        Route::get('/admin/superadmin', [AdminController::class, 'superadmin'])->name('show.welcome.superadmin');
    });

    // Admin Only
    Route::middleware('userAkses:admin')->group(function () {
        Route::get('/admin/admin', [AdminDashboardController::class, 'index'])->name('show.welcome.admin');

        // User Management
        Route::get('users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::post('users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
        
        // Data Padi Route
        Route::prefix('data-padi')->name('admin.data_padi.')->group(function () {
            Route::get('/', [DataPadiController::class, 'index'])->name('index');
            Route::get('/create', [DataPadiController::class, 'create'])->name('create');
            Route::post('/store', [DataPadiController::class, 'store'])->name('store');
            Route::get('/{id}', [DataPadiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [DataPadiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataPadiController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataPadiController::class, 'destroy'])->name('destroy');
        });

        // Product Route 
        Route::prefix('admin/products')->name('admin.products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        });
    });

    // Petani Only
    Route::middleware('userAkses:petani')->group(function () {
        Route::get('/admin/petani', [AdminController::class, 'petani'])->name('show.welcome.petani');
    });

    // Pembeli Only
    Route::middleware('userAkses:pembeli')->group(function () {
        Route::get('/admin/pembeli', [AdminController::class, 'pembeli'])->name('show.welcome.pembeli');

        // Product Route 
        Route::prefix('pembeli/products')->name('pembeli.products.')->group(function () {
            Route::get('/', [ProductListController::class, 'productlist'])->name('index');
            // Route::get('/create', [ProductListController::class, 'create'])->name('create'); 
        });

        // Order Route 
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/store', [OrderController::class, 'store'])->name('store');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        });

        // Payment Route 
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/create', [PaymentController::class, 'create'])->name('create');
            Route::post('/store', [PaymentController::class, 'store'])->name('store');
            Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
            Route::put('/{id}/status', [PaymentController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('destroy');
        });
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
