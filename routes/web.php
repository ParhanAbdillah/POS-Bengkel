<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// Category
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');

// Services
Route::get('/services', [App\Http\Controllers\ServicesController::class, 'index'])->name('services.index');
Route::post('/services', [App\Http\Controllers\ServicesController::class, 'store'])->name('services.store');
Route::get('/services/create', [App\Http\Controllers\ServicesController::class, 'create'])->name('services.create');
Route::get('/services/{service}/edit', [App\Http\Controllers\ServicesController::class, 'edit'])->name('services.edit');
Route::put('/services/{service}', [App\Http\Controllers\ServicesController::class, 'update'])->name('services.update');
Route::delete('/services/{service}', [App\Http\Controllers\ServicesController::class, 'destroy'])->name('services.destroy');


Route::get('/profile', function () {
    return "Halaman Profil";
})->name('profile.edit');

Route::post('/logout', function () {
    return redirect('/');
})->name('logout');
