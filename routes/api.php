<?php

use App\Http\Api\Controllers\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('pets', PetController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
