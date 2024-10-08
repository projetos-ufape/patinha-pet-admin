<?php

use App\Http\Api\Controllers\CustomerAuthController;
use App\Http\Api\Controllers\CustomerController;
use App\Http\Api\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::post('/customers/signup', [CustomerAuthController::class, 'signup'])->name('api.customers.signup');
Route::post('/customers/login', [CustomerAuthController::class, 'login'])->name('api.customers.login');
Route::prefix('customers')->name('api.customers.')->middleware(['auth:sanctum', 'ability:customer'])->group(function () {
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    Route::patch('/', [CustomerController::class, 'update'])->name('update');
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::apiResource('pets', PetController::class);
});
