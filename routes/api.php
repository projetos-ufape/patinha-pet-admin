<?php

use App\Http\Api\Controllers\PetController;
use App\Http\Api\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/customers/signup', [CustomerAuthController::class, 'signup'])->name('api.customers.signup');
Route::post('/customers/login', [CustomerAuthController::class, 'login'])->name('api.customers.login');
Route::prefix('customers')->name('api.customers.')->middleware(['auth:sanctum', 'ability:customer'])->group(function () {
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    Route::apiResource('pets', PetController::class);
});
