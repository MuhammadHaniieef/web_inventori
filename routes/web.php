<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ItemController::class, 'index'])->name('dashboard');
    Route::resource('items', ItemController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('boxes', BoxController::class)->except(['show']);
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('approve.loans');
    Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('reject.loans');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('return.loans');
    Route::get('/stock/histories', [ItemController::class, 'sHistories'])->name('stock.histories');
});

// Rute khusus untuk `boxes.show` tanpa middleware auth
Route::get('/boxes/{box}', [BoxController::class, 'show'])->name('boxes.show');

Route::post('/loans/jebret', [LoanController::class, 'store'])->name('loans.store');
