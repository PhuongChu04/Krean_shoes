<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\CategoryClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;

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
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'homeClient'])->name('homeClient');
});
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/post-login', [AuthenticationController::class, 'postLogin'])->name('postLogin');
    Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthenticationController::class, 'postRegister'])->name('postRegister');
    Route::get('/log-out', [AuthenticationController::class, 'logout'])->name('logout');
});

    // Route::get('/login',[AuthenticationController::class, 'login'])->name('login');
//             ==================  CATEGORY =====================
Route::prefix('listCategory')->name('listCategory.')->group(function () {
    Route::get('/', [AdminCategoryController::class, 'index'])->name('list');

    Route::get('/detail/{id}', [AdminCategoryController::class, 'show'])->name('detailCategory');

    Route::get('/add', [AdminCategoryController::class, 'create'])->name('addCategory');
    Route::post('/store', [AdminCategoryController::class, 'store'])->name('storeCategory');

    Route::get('/edit/{id}', [AdminCategoryController::class, 'edit'])->name('editCategory');
    Route::put('/update{id}', [AdminCategoryController::class, 'update'])->name('updateCategory');

    Route::delete('/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('deleteCategory');
    Route::get('/search', [AdminCategoryController::class, 'search'])->name('searchCategory');
});
//brand
 //==================TRANG DANH MỤC==================
    Route::get('/category/list', [CategoryClientController::class, 'listCategoryClient'])
        ->name('listCategoryClient');
