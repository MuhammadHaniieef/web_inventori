<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ToolCategoryController;
use App\Http\Controllers\UserController;
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

    Route::get('/peminjaman/barang', [LoanController::class, 'index'])->name('loans.dashboard');
    Route::get('/barangs/masuk/', [ItemController::class, 'iBarangDatang'])->name('iBrgDtg');
    Route::post('/barangs/masuk/jeder', [ItemController::class, 'processAssignMultipleToBox'])->name('pAToBox');
    Route::get('/barangs/masuk/create', [ItemController::class, 'cBarangDatang'])->name('cBrgDtg');
    Route::post('/barangs/masuk/jeger', [ItemController::class, 'sBarangDatang'])->name('sBrgDtg');
    Route::resource('categories', CategoryController::class);
    Route::resource('toolscategories', ToolCategoryController::class);
    Route::resource('boxes', BoxController::class)->except(['show']);
    Route::resource('tools', ToolController::class);
    // Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('approve.loans');
    // Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('reject.loans');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('return.loans');
    Route::get('/admin/boxes/{box}/details', [BoxController::class, 'adminBoxDetails'])->name('admin.boxes.details');
    Route::resource('users', UserController::class)->middleware('role:admin');
});

// Rute khusus tanpa middleware auth
// ambil barang
Route::get('/boxes/{box}', [BoxController::class, 'show'])->name('boxes.show');
Route::post('boxes/{box}', [BoxController::class, 'submitBoxForm'])->name('boxes.submit');
Route::post('/update/jeger', [BoxController::class, 'BarangUpdate'])->name('barangs.update');
Route::post('/ambil/jebret', [BoxController::class, 'AmbilBarang'])->name('barangs.ambil');
Route::post('/tambah/jeger', [BoxController::class, 'TambahBarang'])->name('barangs.tambah');
Route::get('/', [DashboardController::class, 'previewPage'])->name('preview');

Route::get('/boxes/{box}/details', [BoxController::class, 'showBoxDetails'])->name('boxes.details');
// pinjam tool
Route::get('/loans/form/', [LoanController::class, 'formSession'])->name('loans.form-name');
Route::post('/loans/form/jebret', [LoanController::class, 'submitFormSession'])->name('loans.name-submit');

Route::get('/loans/tools', [LoanController::class, 'takeForm'])->name('loans.form-tool');
Route::post('/loans/store/jebret', [LoanController::class, 'store'])->name('loans.store');