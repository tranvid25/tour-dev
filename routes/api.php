<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\clients\ForgotPasswordController;
use App\Http\Controllers\clients\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function(){
   Route::post('register',[AdminController::class,'create']);
   Route::post('login',[AdminController::class,'loginPost']);
   Route::middleware('auth:admin-api')->group(function(){
    Route::get('/detailUser/{id}',[AdminController::class,'show']);
    Route::get('/detail/{id}',[AdminController::class,'index']);
    Route::post('logout',[AdminController::class,'logoutAdmin']);
   });
});

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);
Route::prefix('user')->group(function(){
    Route::post('/register',[UserController::class,'register']);
    Route::post('login',[UserController::class,'login']);
    Route::middleware('auth:api')->group(function(){
        Route::get('/detail/{id}',[UserController::class,'index']);
        Route::put('/update/one/{id}',[UserController::class,'update']);
        Route::post('logout',[UserController::class,'logout']);
    });
});
