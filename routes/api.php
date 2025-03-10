<?php

use App\Http\Controllers\Api\DataPadiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/datapadi', DataPadiController::class);

Route::post('datapadi/{id}', [DataPadiController::class, 'update']);
Route::put('datapadi/{id}', [DataPadiController::class, 'update']);

