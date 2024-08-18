<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use  App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/add-product', [ProductController::class, 'create'])->name('products.add');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::patch('/product/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

// Replace later by:
//Route::resource('products', ProductController::class);


Route::resource('stocks', StockController::class)->only(['index', 'create', 'store']);

require __DIR__ . '/auth.php';
// Rota para view cliente
Route::get('/customer', function () {
    return view('customer.index');})->name('customer.index');

require __DIR__.'/auth.php';
