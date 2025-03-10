<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use App\Http\Middleware\UserAkses;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

Route::get('/home', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/superadmin', [AdminController::class, 'superadmin'])->middleware('userAkses'.':superadmin');
    Route::get('/admin/admin', [AdminController::class, 'admin'])->middleware('userAkses'.':admin');
    Route::get('/admin/petani', [AdminController::class, 'petani'])->middleware('userAkses'.':petani');
    Route::get('/admin/pembeli', [AdminController::class, 'pembeli'])->middleware('userAkses'.':pembeli');
    Route::get('/logout', [SesiController::class, 'logout']);
});