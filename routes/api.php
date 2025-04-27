<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Uts3ItemController;
use App\Http\Controllers\Api\Uts3CategoryController;
use App\Http\Controllers\Api\Uts3SupplierController;
use App\Http\Controllers\Api\Uts3ReportController;

/*
| API Routes
*/

// --- Item Routes ---
Route::post('/uts3items', [Uts3ItemController::class, 'store']); // Create Uts3Item
Route::get('/uts3items', [Uts3ItemController::class, 'index']); // Read All Uts3Items
Route::get('/uts3items/{uts3item}', [Uts3ItemController::class, 'show']); // Read Single Uts3Item
// Route::put('/uts3items/{uts3item}', [Uts3ItemController::class, 'update']); // Update Uts3Item (Tambahkan jika perlu)
// Route::delete('/uts3items/{uts3item}', [Uts3ItemController::class, 'destroy']); // Delete Uts3Item (Tambahkan jika perlu)

// --- Category Routes ---
Route::post('/uts3categories', [Uts3CategoryController::class, 'store']); // Create Uts3Category
Route::get('/uts3categories', [Uts3CategoryController::class, 'index']); // Read All Uts3Categories
Route::get('/uts3categories/{uts3category}', [Uts3CategoryController::class, 'show']); // Read Single Uts3Category
// Route::put('/uts3categories/{uts3category}', [Uts3CategoryController::class, 'update']); // Update Uts3Category (Tambahkan jika perlu)
// Route::delete('/uts3categories/{uts3category}', [Uts3CategoryController::class, 'destroy']); // Delete Uts3Category (Tambahkan jika perlu)

// --- Supplier Routes ---
Route::post('/uts3suppliers', [Uts3SupplierController::class, 'store']); // Create Uts3Supplier
Route::get('/uts3suppliers', [Uts3SupplierController::class, 'index']); // Read All Uts3Suppliers
Route::get('/uts3suppliers/{uts3supplier}', [Uts3SupplierController::class, 'show']); // Read Single Uts3Supplier
// Route::put('/uts3suppliers/{uts3supplier}', [Uts3SupplierController::class, 'update']); // Update Uts3Supplier (Tambahkan jika perlu)
// Route::delete('/uts3suppliers/{uts3supplier}', [Uts3SupplierController::class, 'destroy']); // Delete Uts3Supplier (Tambahkan jika perlu)

// --- Report Routes ---
Route::get('/uts3reports/stock-summary', [Uts3ReportController::class, 'stockSummary']); // Ringkasan Stok
Route::get('/uts3reports/low-stock', [Uts3ReportController::class, 'lowStockItems']); // Barang Stok Rendah
Route::get('/uts3reports/items-by-category/{uts3category}', [Uts3ReportController::class, 'itemsByCategory']); // Barang per Kategori

// Contoh rute untuk mendapatkan user yang sedang login (jika ada auth)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
// });