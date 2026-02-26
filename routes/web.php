<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
    Route::get('/listCategory', [AdminController::class, 'listCate'])->name('listCate');
    Route::get('/listProduct', [AdminController::class, 'listProduct'])->name('listProduct');
    
    // Routes cho Sizes CRUD
    Route::resource('sizes', SizeController::class);
    Route::get('/sizes-trash', [SizeController::class, 'trash'])->name('sizes.trash');
    Route::post('/sizes/{id}/restore', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::delete('/sizes/{id}/force-delete', [SizeController::class, 'forceDelete'])->name('sizes.force-delete');
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'homeClient'])->name('homeClient');

});