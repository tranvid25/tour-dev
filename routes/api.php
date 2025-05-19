<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\clients\BookingController;
use App\Http\Controllers\clients\ForgotPasswordController;
use App\Http\Controllers\clients\ReasonController;
use App\Http\Controllers\clients\TourController;
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
    //TOUR
    Route::get('/tour/{id}',[TourController::class,'show']);
    Route::delete('/tour/{id}',[TourController::class,'destroy']);
    Route::put('/tour/{id}',[TourController::class,'update']);
    Route::post('/tour',[TourController::class,'store']);
    //Booking
    Route::get('/booking',[BookingController::class,'index']);
    Route::get('/booking/{id}',[BookingController::class,'show']);
    //Reason
    Route::get('/reason',[ReasonController::class,'index']);
    Route::get('/reason/{id}',[ReasonController::class,'show']);
    Route::post('/reason',[ReasonController::class,'store']);
    Route::put('/reason/{id}',[ReasonController::class,'update']);
    Route::delete('/reason/{id}',[ReasonController::class,'destroy']);

   });
});
Route::post('/login/googleC2', [UserController::class, 'loginGoogleC2']);
Route::post('login/google', [UserController::class, 'loginGoogle']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);
Route::prefix('user')->group(function(){
    Route::post('/register',[UserController::class,'register']);
    Route::post('login',[UserController::class,'login']);
    Route::middleware('auth:api')->group(function(){
        Route::get('/detail/{id}',[UserController::class,'index']);
        Route::put('/update/one/{id}',[UserController::class,'update']);
        Route::post('logout',[UserController::class,'logout']);
        //TOUR
        Route::get('/tour',[TourController::class,'index']);
        //Booking
        Route::post('booking',[BookingController::class,'store']);
        Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
        //Reason cancel Booking
        Route::get('/reason',[ReasonController::class,'index']);
    });
});
