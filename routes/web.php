<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ToolCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGuideController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ItemController::class, 'index'])->name('dashboard')->middleware('role:admin');
    Route::get('/items', [ItemController::class, 'indexItem'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    Route::get('/loans/items', [LoanController::class, 'index'])->name('loans.dashboard');
    Route::get('/items/incoming', [ItemController::class, 'iBarangDatang'])->name('iBrgDtg');
    Route::post('/items/incoming/assign', [ItemController::class, 'processAssignMultipleToBox'])->name('pAToBox');
    Route::get('/items/incoming/create', [ItemController::class, 'cBarangDatang'])->name('cBrgDtg');
    Route::post('/items/incoming/submit', [ItemController::class, 'sBarangDatang'])->name('sBrgDtg');
    Route::resource('categories', CategoryController::class);
    Route::resource('toolscategories', ToolCategoryController::class);
    Route::resource('boxes', BoxController::class)->except(['show']);
    Route::resource('tools', ToolController::class);
    // Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('approve.loans');
    // Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('reject.loans');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('return.loans');
    Route::get('/admin/boxes/{box}/details', [BoxController::class, 'adminBoxDetails'])->name('admin.boxes.details');
    Route::post('/update/submit', [BoxController::class, 'BarangUpdate'])->name('items.stock.update');
    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::get('/manual', [UserGuideController::class, 'index'])->name('manual.index');
    Route::post('/manual/upload', [UserGuideController::class, 'upload'])->name('manual.upload');
    Route::get('/manual/view/{id}', [UserGuideController::class, 'view'])->name('manual.view');
    Route::get('/manual/download/{id}', [UserGuideController::class, 'download'])->name('manual.download');
    Route::delete('/manual/delete/{id}', [UserGuideController::class, 'delete'])->name('manual.delete');
});

// Rute khusus tanpa middleware auth
// user guide

// ambil barang
Route::get('/boxes/{box}', [BoxController::class, 'show'])->name('boxes.show');
Route::post('boxes/{box}', [BoxController::class, 'submitBoxForm'])->name('boxes.submit');
Route::post('/take/submit', [BoxController::class, 'AmbilBarang'])->name('items.take');
Route::get('/', [DashboardController::class, 'previewPage'])->name('preview');

Route::get('/boxes/{box}/details', [BoxController::class, 'showBoxDetails'])->name('boxes.details');
// pinjam tool
Route::get('/loans/form/', [LoanController::class, 'formSession'])->name('loans.form-name');
Route::post('/loans/form/submit', [LoanController::class, 'submitFormSession'])->name('loans.name-submit');

Route::get('/loans/tools', [LoanController::class, 'takeForm'])->name('loans.form-tool');
Route::post('/loans/store/submit', [LoanController::class, 'store'])->name('loans.store');