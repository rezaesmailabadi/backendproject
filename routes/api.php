<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
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

Route::get('Categories',[CategoryController::class,'index']);
Route::get('Categories/{id}',[CategoryController::class,'show']);
Route::post('addnew',[CategoryController::class,'store']);
Route::put('update/{id}',[CategoryController::class,'update']);
Route::delete('delete/{id}',[CategoryController::class,'destroy']);





Route::get('orders',[OrderController::class,'index']);
Route::get('orders/{id}',[OrderController::class,'show']);
Route::post('addorder',[OrderController::class,'store']);
Route::put('updateorder/{id}',[OrderController::class,'update']);
Route::delete('deleteorder/{id}',[OrderController::class,'destroy']);