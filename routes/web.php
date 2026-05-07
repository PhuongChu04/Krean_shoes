<?php

use App\Http\Controllers\admin\Account\AccountAdminController;
use App\Http\Controllers\admin\Account\AccountUsersController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WebInfoController;
use App\Http\Controllers\Auth\AuthClientController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Client\CartsController;
use App\Http\Controllers\Client\CategoryClientController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductsController;
use App\Http\Controllers\Client\ReviewController as ReviewClientController;
use Illuminate\Support\Facades\Route;

Route::get('/payment/vnpay-return', [CheckoutController::class, 'vnpayReturn'])
    ->name('payment.vnpay.return');

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'homeClient'])->name('homeClient');
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/{slug}', [ProductsController::class, 'show'])
            ->name('detail');
        Route::get('/product/variant', [ProductsController::class, 'getVariant'])
            ->name('product.variant');

        // Nếu bạn muốn dùng ID thay vì slug (đơn giản hơn):
        // Route::get('/{id}', [\App\Http\Controllers\Client\ProductsController::class, 'show'])
        //     ->name('detail');

    });

    Route::middleware('checkClient')->group(function () {
        Route::get('/account', [AuthClientController::class, 'showDetailAccount'])
            ->name('account.detail');

        Route::put('/account', [AuthClientController::class, 'updateAccount'])
            ->name('account.update');

        // Checkout route
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

        // Order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/reviews', [ReviewClientController::class, 'store'])
            ->name('reviews.store');
    });
});

// Route::get('/', [ClientController::class, 'homeClient'])->name('homeClient');

// route cho hiển thị danh sách sản phẩm
Route::get('/shop', [ProductsController::class, 'index'])->name('shop.index');
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/post-login', [AuthenticationController::class, 'postLogin'])->name('postLogin');
    Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthenticationController::class, 'postRegister'])->name('postRegister');
    Route::get('/log-out', [AuthenticationController::class, 'logout'])->name('logout');
});
// Nhóm route cho carts có middleware checkClient
Route::middleware('checkClient')->group(function () {
    Route::get('/cart', [CartsController::class, 'index'])->name('cart.index');

    // giỏ hàng
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartsController::class, 'index'])->name('view');
        Route::get('/data', [CartsController::class, 'getCartData'])->name('data');
        Route::post('/add', [CartsController::class, 'addToCart'])->name('add');
        Route::post('/update-quantity/{id}', [CartsController::class, 'updateQuantity'])->name('updateQuantity');
        Route::post('/delete-multiple', [CartsController::class, 'deleteMultiple'])->name('deleteMultiple');
        Route::delete('/{id}', [CartsController::class, 'remove'])->name('remove');
    });
});

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
    Route::resource('vouchers', VoucherController::class);
    Route::get('/vouchers-trash', [VoucherController::class, 'trash'])->name('vouchers.trash');
    Route::post('/vouchers/{id}/restore', [VoucherController::class, 'restore'])->name('vouchers.restore');
    Route::delete('/vouchers/{id}/force-delete', [VoucherController::class, 'forceDelete'])->name('vouchers.force-delete');

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

    // order
    Route::prefix('/order')->name('order.')->group(function () {
        Route::get('/list', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('status');
        // Route::get('/orders/stats', [AdminOrderController::class, 'dashboard'])->name('stats');
        Route::put('/{id}/update-receiver', [AdminOrderController::class, 'updateReceiver'])
            ->name('update-receiver');
        // Route::get('/orders/stats', [AdminOrderController::class, 'dashboard'])->name('stats');
        // Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
    });

    // Quản lý brands
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::get('/trashed', [BrandController::class, 'trash'])->name('trash');
        Route::get('/{slug}', [BrandController::class, 'show'])->name('show');
        Route::get('/{slug}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/{slug}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{slug}', [BrandController::class, 'destroy'])->name('destroy');
        Route::post('/{slug}/restore', [BrandController::class, 'restore'])->name('restore');
        Route::delete('/{slug}/force-delete', [BrandController::class, 'forceDelete'])->name('forceDelete');
        Route::post('/bulk-delete', [BrandController::class, 'bulkSoftDelete'])->name('bulkSoftDelete');
    });

    // Đơn chờ xử lý
    Route::get('/orders/pending', [AdminController::class, 'pending'])
        ->name('orders.pending');

    // Sản phẩm còn hàng
    Route::get('/instock', [AdminController::class, 'instock'])
        ->name('instock');

    // đánh giá 
    Route::get('/reviews', [ReviewController::class, 'index'])->name('review');
    Route::get('/{review}', [ReviewController::class, 'show'])->name('showReview');
    Route::post('/{review}/reply', [ReviewController::class, 'reply'])->name('reply');
    Route::put('/{review}/status', [ReviewController::class, 'updateStatus'])->name('status');
    // Quản lý banner
    Route::prefix('/banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/{banner}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::put('/{banner}/update', [BannerController::class, 'update'])->name('update');
        Route::delete('/{banner}/destroy', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Nhóm quản lý tài khoản
    Route::prefix('/account')->name('account.')->group(function () {
        // Route::prefix('/comment')->name('comment.')->group(function () {
        //     Route::get('/users/{user}/comments/trashed', [CommentController::class, 'getTrashedComments'])
        //         ->name('account.trashedComments');
        //     Route::post('/restore/{comment}', [CommentController::class, 'restoreCommentAjax'])->name('restoreComment');
        //     Route::post('/toggleStatus/{id}', [CommentController::class, 'toggleStatus'])->name('toggleStatus');
        //     Route::delete('/forceDelete/{id}', [CommentController::class, 'forceDelete'])->name('forceDelete');
        //     Route::get('/{comment}/details-with-product', [CommentController::class, 'getCommentDetailsWithProduct'])
        //         ->name('detailWithProduct');
        //     Route::post('/soft-delete/{comment}', [CommentController::class, 'softDeleteCommentAjax'])->name('softDeleteComment');

        //     Route::post('/approve/{comment}', [CommentController::class, 'approveCommentAjax'])->name('approveComment');
        //     Route::post('/hide/{comment}', [CommentController::class, 'hideCommentAjax'])->name('hideComment');
        //     Route::post('/show-again/{comment}', [CommentController::class, 'showAgainCommentAjax'])->name('showAgainComment');
        // });
        // client
        Route::get('/listUsers', [AccountUsersController::class, 'listUsers'])->name('listUsers');
        Route::get('/detailAccUser/{id}', [AccountUsersController::class, 'detailAccUser'])->name('detailAccUser');
        Route::post('/softDeleteUser/{id}', [AccountUsersController::class, 'softDeleteUser'])->name('softDeleteUser');
        Route::get('/trashedUsers', [AccountUsersController::class, 'trashedUsers'])->name('trashedUsers');
        Route::post('/restoreUser/{id}', [AccountUsersController::class, 'restoreUser'])->name('restoreUser');
        Route::delete('/forceDeleteUser/{id}', [AccountUsersController::class, 'forceDeleteUser'])->name('forceDeleteUser');
        Route::post('/resetPassUser/{id}', [AccountUsersController::class, 'resetPassUser'])->name('resetPassUser');
        Route::get('/orders/{order}/ajax-details', [AccountUsersController::class, 'getAjaxOrderDetails'])
            ->name('order.ajaxDetails');
        // ROUTE MỚI CHO PHÂN QUYỀN
        Route::post('toggleUserRole/{user}', [AccountUsersController::class, 'toggleUserRole'])->name('toggleUserRole');
        // Admins
        Route::get('/listAdmins', [AccountAdminController::class, 'listAdmins'])->name('listAdmins');
        Route::get('/detailAccAdmin/{id}', [AccountAdminController::class, 'detailAccAdmin'])->name('detailAccAdmin');
        Route::get('/createAdmin', [AccountAdminController::class, 'createAdmin'])->name('createAdmin');
        Route::post('/storeAdmin', [AccountAdminController::class, 'storeAdmin'])->name('storeAdmin');
        Route::get('/editAdmin/{id}', [AccountAdminController::class, 'editAdmin'])->name('editAdmin');
        Route::post('/updateAdmin/{id}', [AccountAdminController::class, 'updateAdmin'])->name('updateAdmin');
        Route::post('/softDeleteAdmin/{id}', [AccountAdminController::class, 'softDeleteAdmin'])->name('softDeleteAdmin');
        Route::get('/trashedAdmins', [AccountAdminController::class, 'trashedAdmins'])->name('trashedAdmins');
        Route::post('/restoreAdmin/{id}', [AccountAdminController::class, 'restoreAdmin'])->name('restoreAdmin');
        Route::delete('/forceDeleteAdmin/{id}', [AccountAdminController::class, 'forceDeleteAdmin'])->name('forceDeleteAdmin');
        Route::post('/resetPassAdmin/{id}', [AccountAdminController::class, 'resetPassAdmin'])->name('resetPassAdmin');
        // ROUTE MỚI CHO PHÂN QUYỀN
        // Route::post('toggleUserRole/{admin}', [AccountAdminController::class, 'toggleUserRole'])->name('toggleUserRole');

        // Hiển thị thông tin cấu hình website
        Route::get('/webinfor', [WebInfoController::class, 'show'])->name('webinfor');
        Route::get('/webinfor/edit', [WebInfoController::class, 'edit'])->name('web_info.edit');
        Route::post('/webinfor/update', [WebInfoController::class, 'update'])->name('web_info.update');
    });

    // quản lý blog_category
    Route::prefix('/blog-categories')->name('blog_categories.')->group(function () {
        Route::get('/list', [BlogCategoryController::class, 'index'])->name('index');
        Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
        Route::post('/store', [BlogCategoryController::class, 'store'])->name('store');
        Route::get('/{slug}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
        Route::put('/{slug}/update', [BlogCategoryController::class, 'update'])->name('update');
        Route::delete('/{slug}/destroy', [BlogCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/trash', [BlogCategoryController::class, 'trash'])->name('trash');
        Route::post('/{slug}/restore', [BlogCategoryController::class, 'restore'])->name('restore');
        Route::delete('/{slug}/force_delete', [BlogCategoryController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/{slug}', [BlogCategoryController::class, 'show'])->name('show');
    });

    Route::prefix('/blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/show/{id}', [BlogController::class, 'show'])->name('show');
        Route::get('/create', [BlogController::class, 'create'])->name(name: 'create');
        Route::get('/edit/{id}', action: [BlogController::class, 'edit'])->name('edit');
        Route::post('/store', [BlogController::class, 'store'])->name('store');
        Route::put('/store/{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('/destroy', [BlogController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
    });
});
