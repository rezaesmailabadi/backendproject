<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Auth\Customer\LoginRegisterController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\popularController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
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




//order
Route::get('relatedproducts/{id}', [OrderController::class, 'Relatedproducts']);
Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
// Route::post('addorder', [OrderController::class, 'store']);
Route::any('addorder', [OrderController::class, 'store']);
Route::get('newsorder', [OrderController::class, 'newsorder']); //new
Route::get('ordercategory/{id}', [CategoryController::class, 'ordercategory']);
Route::get('order-datails/{id}', [OrderController::class, 'datail']);
Route::put('updateorder/{id}', [OrderController::class, 'update']);
Route::delete('deleteorder/{id}', [OrderController::class, 'destroy']);





//gallery
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/create/{id}', [GalleryController::class, 'create']);
Route::post('/gallery/store', [GalleryController::class, 'store']);
Route::delete('/gallery/destroy/{id}', [GalleryController::class, 'destroy']);




//category
Route::get('Categories', [CategoryController::class, 'index']);
Route::get('Categories/{id}', [CategoryController::class, 'show']);
Route::post('addnew', [CategoryController::class, 'store']);
Route::put('update/{id}', [CategoryController::class, 'update']);
Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
Route::get('ordercategory/{id}', [CategoryController::class, 'ordercategory']);
Route::get('ordercategorydatails/{id}', [CategoryController::class, 'ordercategorydatails']);









///بیشترین بازدید بر اساس آی پی
Route::get('order-favorites', [FavoriteController::class, 'index']);
//// بر اساس لایک محبوب ترین ها
Route::post('like-unlike-order', [LikeController::class, 'store']);
Route::get('order-popular', [popularController::class, 'index']);

//login register
Route::post('/login-register', [LoginRegisterController::class, 'loginRegister']);
Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');





////profile
Route::get('my-profile/{id}', [ProfileController::class, 'myProfile']);
Route::post('change-password/{id}', [ProfileController::class, 'change_password']);
Route::post('update-profile/{id}', [ProfileController::class, 'update_profile']);
Route::get('my_order/{id}', [ProfileController::class, 'my_order']);
Route::get('my_popular_order/{id}', [ProfileController::class, 'my_popular_order']);


Route::get('payment', [PaymentController::class, 'paymentSubmit']);




//آگهی در انتظار تایید
Route::get('Awaiting_confirmation/{id}', [ProfileController::class, 'Awaiting_confirmation']);


//search
Route::get('search/{query?}', [SearchController::class, 'search']);


//filter min_price max_price
Route::get('filterprice/{request?}', [SearchController::class, 'price']);
