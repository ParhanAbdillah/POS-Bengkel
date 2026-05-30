<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
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

// Mechanics
Route::get('/mechanics', [App\Http\Controllers\MechanicsController::class, 'index'])->name('mechanics.index');
Route::post('/mechanics', [App\Http\Controllers\MechanicsController::class, 'store'])->name('mechanics.store');
Route::get('/mechanics/create', [App\Http\Controllers\MechanicsController::class, 'create'])->name('mechanics.create');
Route::get('/mechanics/{mechanic}/edit', [App\Http\Controllers\MechanicsController::class, 'edit'])->name('mechanics.edit');
Route::put('/mechanics/{mechanic}', [App\Http\Controllers\MechanicsController::class, 'update'])->name('mechanics.update');
Route::delete('/mechanics/{mechanic}', [App\Http\Controllers\MechanicsController::class, 'destroy'])->name('mechanics.destroy');

// Spareparts
Route::get('/spareparts', [App\Http\Controllers\SparepartController::class, 'index'])->name('spareparts.index');
Route::post('/spareparts', [App\Http\Controllers\SparepartController::class, 'store'])->name('spareparts.store');
Route::get('/spareparts/create', [App\Http\Controllers\SparepartController::class, 'create'])->name('spareparts.create');
Route::get('/spareparts/{sparepart}/edit', [App\Http\Controllers\SparepartController::class, 'edit'])->name('spareparts.edit');
Route::put('/spareparts/{sparepart}', [App\Http\Controllers\SparepartController::class, 'update'])->name('spareparts.update');
Route::delete('/spareparts/{sparepart}', [App\Http\Controllers\SparepartController::class, 'destroy'])->name('spareparts.destroy');

    Route::get('/profile', function () {
        return "Halaman Profil";
    })->name('profile.edit');
});
