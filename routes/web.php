<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('admin')->name('admin.')->middleware('checkAdmin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
Route::get('/listCategory', [AdminController::class, 'listCate'])->name('listCate');
Route::get('/listProduct', [AdminController::class, 'listProduct'])->name('listProduct');
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
