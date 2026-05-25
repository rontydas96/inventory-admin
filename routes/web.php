<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::get('/products/upload', [ProductController::class, 'uploadForm'])
        ->name('products.upload');

    Route::post('/products/upload', [ProductController::class, 'upload'])
        ->name('products.upload.post');

    Route::get('/purchases', [PurchaseController::class, 'index'])
        ->name('purchases.index');

    Route::get('/purchases/create', [PurchaseController::class, 'create'])
        ->name('purchases.create');

    Route::post('/purchases', [PurchaseController::class, 'store'])
        ->name('purchases.store');

    Route::get('/purchases/search', [PurchaseController::class, 'search'])
        ->name('purchases.search');

    Route::get('/purchases/products/search', [PurchaseController::class, 'productSearch'])
        ->name('purchases.products.search');

    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])
        ->name('purchases.show');

    Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])
        ->name('purchases.edit');

    Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])
        ->name('purchases.update');

    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])
        ->name('purchases.destroy');

    Route::get('/purchases/{purchase}/download', [PurchaseController::class, 'download'])
        ->name('purchases.download');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::get('/sales/search', [SaleController::class, 'search'])
        ->name('sales.search');

    Route::get('/sales/customers', [SaleController::class, 'customerSearch'])
        ->name('sales.customers.search');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/{sale}', [SaleController::class, 'show'])
        ->name('sales.show');

    Route::get('/sales/{sale}/download', [SaleController::class, 'download'])
        ->name('sales.download');

    Route::get('/settings', [SettingController::class, 'edit'])
        ->name('settings.edit');

    Route::post('/settings', [SettingController::class, 'update'])
        ->name('settings.update');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/export-sales-csv', [ReportController::class, 'exportSalesCsv'])
        ->name('reports.exportSalesCsv');

    Route::get('/sales/{sale}/success', [SaleController::class, 'success'])
        ->name('sales.success');

    Route::get('/sales/{sale}/download', [SaleController::class, 'downloadPdf'])
        ->name('sales.download');
});




