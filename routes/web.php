<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Auth\AuthClientController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Client\CategoryClientController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('admin')->name('admin.')->middleware('checkAdmin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
    // Route::get('/listCategory', [AdminController::class, 'listCate'])->name('listCate');
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
    // Thêm variant mới cho sản phẩm cụ thể
    Route::post('products/{product}/variants', [ProductController::class, 'storeVariant'])
        ->name('products.variants.store');


    // Routes cho Sizes CRUD
    Route::resource('sizes', SizeController::class);
    Route::get('/sizes-trash', [SizeController::class, 'trash'])->name('sizes.trash');
    Route::post('/sizes/{id}/restore', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::delete('/sizes/{id}/force-delete', [SizeController::class, 'forceDelete'])->name('sizes.force-delete');

    // Routes cho Vouchers CRUD
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
    Route::get('/vouchers-trash', [\App\Http\Controllers\Admin\VoucherController::class, 'trash'])->name('vouchers.trash');
    Route::post('/vouchers/{id}/restore', [\App\Http\Controllers\Admin\VoucherController::class, 'restore'])->name('vouchers.restore');
    Route::delete('/vouchers/{id}/force-delete', [\App\Http\Controllers\Admin\VoucherController::class, 'forceDelete'])->name('vouchers.force-delete');



    // Route::prefix('listCategory')->name('listCategory.')->group(function () {
    Route::get('/list', [CategoryController::class, 'index'])->name('list');

    Route::get('/detail/{id}', [CategoryController::class, 'show'])->name('detailCategory');

    Route::get('/add', [CategoryController::class, 'create'])->name('addCategory');
    Route::post('/store', [CategoryController::class, 'store'])->name('storeCategory');

    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('editCategory');
    Route::put('/update{id}', [CategoryController::class, 'update'])->name('updateCategory');

    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');
    Route::get('/search', [CategoryController::class, 'search'])->name('searchCategory');
    // });
    Route::prefix('/color')->name('color.')->group(function () {
        // Route::get('/', [ColorController::class, 'list'])->name('listColor');
        Route::get('/list', [ColorController::class, 'list'])->name('listColor');
        Route::get('/add', [ColorController::class, 'create'])->name('addColor');
        Route::post('/store', [ColorController::class, 'store'])->name('storeColor');
        Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('editColor');
        Route::post('/update/{id}', [ColorController::class, 'update'])->name('updateColor');
        Route::get('/delete/{id}', [ColorController::class, 'destroy'])->name('deleteColor');
        Route::get('/bulk-delete', [ColorController::class, 'bulkDelete'])->name('bulkDeleteColor');
        Route::get('/trash', [ColorController::class, 'trash'])->name('trashColor');
        Route::get('/restore/{id}', [ColorController::class, 'restore'])->name('restoreColor');
        Route::get('/bulk-restore', [ColorController::class, 'bulkRestore'])->name('bulkRestoreColor');
        Route::get('/force-delete/{id}', [ColorController::class, 'forceDelete'])->name('forceDeleteColor');
    });
});














Route::get('/', [ClientController::class, 'homeClient'])->name('homeClient');
Route::middleware('checkClient')->group(function () {
    Route::get('/account', [AuthClientController::class, 'showDetailAccount'])
        ->name('account.detail');

    Route::put('/account', [AuthClientController::class, 'updateAccount'])
        ->name('account.update');
});
// route cho hiển thị danh sách sản phẩm
Route::get('/shop', [ProductsController::class, 'index'])->name('shop.index');
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/post-login', [AuthenticationController::class, 'postLogin'])->name('postLogin');
    Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthenticationController::class, 'postRegister'])->name('postRegister');
    Route::get('/log-out', [AuthenticationController::class, 'logout'])->name('logout');
});
