<?php

use App\Http\Controllers\Auth\Customer\LoginRegisterController;
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






Route::namespace('Auth')->group(function () {

    // Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');

    Route::middleware('throttle:customer-login-register-limiter')->post('/login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.customer.login-register');

    Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');

    Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
    Route::middleware('throttle:customer-login-resend-otp-limiter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
    Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');
});








