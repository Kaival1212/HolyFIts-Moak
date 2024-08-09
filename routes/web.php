<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MainpageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [MainpageController::class, 'show'])->name('home');

Route::get('/collections/{slug}', [CollectionController::class, 'index'])->name('collection.show');

Route::get('/{collection}/product/{product}', [ProductController::class, 'index'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
