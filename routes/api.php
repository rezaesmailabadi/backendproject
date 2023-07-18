<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Auth\Customer\LoginRegisterController;
use App\Http\Controllers\GalleryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/home', [HomeController::class, 'latestorder']);



Route::get('/Categories', [CategoryController::class, 'index']);

// اگر نشد / رو بزار
Route::get('orders', [OrderController::class, 'index']); //new
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::post('addorder', [OrderController::class, 'store']);
Route::get('newsorder', [OrderController::class, 'newsorder']); //new

Route::get('ordercategory/{id}',[CategoryController::class,'ordercategory']);




Route::put('updateorder/{id}', [OrderController::class, 'update']);
Route::delete('deleteorder/{id}', [OrderController::class, 'destroy']);


Route::get('my_order', [OrderController::class, 'my_order']);


//gallery
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/create/{id}', [GalleryController::class, 'create']);
Route::post('/gallery/store', [GalleryController::class, 'store']);
Route::delete('/gallery/destroy/{id}', [GalleryController::class, 'destroy']);



// Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');

Route::post('/login-register', [LoginRegisterController::class, 'loginRegister']);




Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');











Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
Route::middleware('throttle:customer-login-resend-otp-limiter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');
