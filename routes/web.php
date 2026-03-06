<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('admin')->name('admin.')->middleware('checkAdmin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
Route::get('/listCategory', [AdminController::class, 'listCate'])->name('listCate');
Route::get('/listProduct', [ProductController::class, 'listProduct'])->name('listProduct');
Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');

Route::post('/products/store', [ProductController::class, 'store'])
    ->name('products.store');
    // SHOW (CHI TIẾT)
    Route::get('/products/{id}', [ProductController::class, 'show'])
        ->name('products.show');

    // EDIT FORM
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    // UPDATE
    Route::put('/products/{id}', [ProductController::class, 'update'])
        ->name('products.update');

    // DELETE
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])
        ->name('products.destroy');
    // EDIT VARIANT RIÊNG
Route::get('/products/variants/{variant}/edit', [ProductController::class, 'editVariant'])
    ->name('products.variants.edit');

// UPDATE VARIANT RIÊNG
Route::put('/products/variants/{variant}', [ProductController::class, 'updateVariant'])
    ->name('products.variants.update');

// (Tùy chọn) XÓA VARIANT RIÊNG
Route::delete('/products/variants/{variant}', [ProductController::class, 'destroyVariant'])
    ->name('products.variants.destroy');
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'homeClient'])->name('homeClient');

});
Route::prefix('auth')->name('auth.')->group(function(){
    Route::get('/login',[AuthenticationController::class, 'login'])->name('login');
     Route::post('/post-login',[AuthenticationController::class, 'postLogin'])->name('postLogin');
    Route::get('/register',[AuthenticationController::class, 'register'])->name('register');
     Route::post('/post-register',[AuthenticationController::class, 'postRegister'])->name('postRegister');
     Route::get('/log-out',[AuthenticationController::class, 'logout'])->name('logout');

});
    // Route::get('/login',[AuthenticationController::class, 'login'])->name('login');
