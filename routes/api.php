<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Auth\Customer\LoginRegisterController;
use App\Http\Controllers\GalleryController;
<<<<<<< HEAD
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\popularController;
=======
>>>>>>> 38ff09f35353048d8d123821bf52c6687edd3769
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/home', [HomeController::class, 'latestorder']);



Route::get('/Categories', [CategoryController::class, 'index']);

<<<<<<< HEAD

Route::get('orders',[OrderController::class,'index']);
Route::get('orders/{id}',[OrderController::class,'show']);
Route::post('addorder',[OrderController::class,'store']);
Route::put('updateorder/{id}',[OrderController::class,'update']);
Route::delete('deleteorder/{id}',[OrderController::class,'destroy']);
=======
// اگر نشد / رو بزار
Route::get('orders', [OrderController::class, 'index']); //new
Route::get('orders/{id}', [OrderController::class, 'show']);
>>>>>>> 38ff09f35353048d8d123821bf52c6687edd3769



Route::any('addorder', [OrderController::class, 'store']);


Route::get('newsorder', [OrderController::class, 'newsorder']); //new

Route::get('ordercategory/{id}', [CategoryController::class, 'ordercategory']);

Route::get('order-datails/{id}', [OrderController::class, 'datail']);



Route::put('updateorder/{id}', [OrderController::class, 'update']);
Route::delete('deleteorder/{id}', [OrderController::class, 'destroy']);


Route::get('my_order', [OrderController::class, 'my_order']);


//gallery
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/create/{id}', [GalleryController::class, 'create']);
Route::post('/gallery/store', [GalleryController::class, 'store']);
Route::delete('/gallery/destroy/{id}', [GalleryController::class, 'destroy']);



<<<<<<< HEAD


Route::namespace('Auth')->group(function () {

    // Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');

    Route::middleware('throttle:customer-login-register-limiter')->post('/login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.customer.login-register');

    Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');

    Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
    Route::middleware('throttle:customer-login-resend-otp-limiter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
    Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');
});


Route::get('Categories', [CategoryController::class, 'index']);
Route::get('Categories/{id}', [CategoryController::class, 'show']);
Route::post('addnew', [CategoryController::class, 'store']);
Route::put('update/{id}', [CategoryController::class, 'update']);
Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
Route::get('ordercategory/{id}', [CategoryController::class, 'ordercategory']);
Route::get('ordercategorydatails/{id}', [CategoryController::class, 'ordercategorydatails']);







Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::post('addorder', [OrderController::class, 'store']);
Route::put('updateorder/{id}', [OrderController::class, 'update']);
Route::delete('deleteorder/{id}', [OrderController::class, 'destroy']);




///بیشترین بازدید بر اساس آی پی
Route::get('order-favorites', [FavoriteController::class, 'index']);


//// بر اساس لایک محبوب ترین ها
Route::post('like-unlike-order', [LikeController::class, 'store']);
Route::get('order-popular', [popularController::class, 'index']);






=======
>>>>>>> 38ff09f35353048d8d123821bf52c6687edd3769
// Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');

Route::post('/login-register', [LoginRegisterController::class, 'loginRegister']);




Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');











Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
Route::middleware('throttle:customer-login-resend-otp-limiter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');
