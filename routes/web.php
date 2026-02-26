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
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'homeClient'])->name('homeClient');

});