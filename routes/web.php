<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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

// Transactions
Route::get('/antrian-servis', [App\Http\Controllers\TransactionController::class, 'queueInfo'])->name('transactions.queue');
Route::get('/api/antrian-servis', [App\Http\Controllers\TransactionController::class, 'queueData'])->name('transactions.queueData');

Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/create', [App\Http\Controllers\TransactionController::class, 'create'])->name('transactions.create');
Route::get('/transactions/{transaction}/edit', [App\Http\Controllers\TransactionController::class, 'edit'])->name('transactions.edit');
Route::get('/transactions/{transaction}/print', [App\Http\Controllers\TransactionController::class, 'print'])->name('transactions.print');
Route::put('/transactions/{transaction}', [App\Http\Controllers\TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [App\Http\Controllers\TransactionController::class, 'destroy'])->name('transactions.destroy');

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

// Customers
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
Route::post('/customers', [App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
Route::post('/customers/ajax', [App\Http\Controllers\CustomerController::class, 'storeAjax'])->name('customers.storeAjax');
Route::get('/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
Route::get('/customers/{customer}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');

// Vehicles
Route::post('/vehicles/ajax', [App\Http\Controllers\VehicleController::class, 'storeAjax'])->name('vehicles.storeAjax');
Route::resource('/vehicles', App\Http\Controllers\VehicleController::class);

// Transactions
Route::get('/transactions/returns', [App\Http\Controllers\TransactionController::class, 'returns'])->name('transactions.returns');
Route::get('/track/{invoice_number}', [App\Http\Controllers\TransactionController::class, 'track'])->name('transactions.track');
Route::resource('/transactions', App\Http\Controllers\TransactionController::class);

// Product Sales
Route::get('/product-sales/print/{id}', [App\Http\Controllers\ProductSaleController::class, 'print'])->name('product-sales.print');
Route::resource('/product-sales', App\Http\Controllers\ProductSaleController::class);

// Reports
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/print', [App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');

    Route::get('/profile', function () {
        return "Halaman Profil";
    })->name('profile.edit');
});
