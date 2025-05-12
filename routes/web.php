<?php

use App\Events\MessageSent;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\LoginController;
use App\Http\Controllers\clients\UserController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//chat
Route::get('chat',function(){
    return view('clients.Chat.chat');
});


//login with goole
Route::get('google/login',[GoogleController::class,'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback',[GoogleController::class,'handleGoogleCallback'])->name('google.callback');
//login with fb
Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
// user
Route::get('/home',[HomeController::class,'index'])->name('home');
Route::get('/register',[AuthController::class,'index_register'])->name('index_register');
Route::post('/register',[AuthController::class,'register'])->name('form_register');
Route::get('/login',[AuthController::class,'index_login'])->name('index_login');
Route::post('/login',[AuthController::class,'login'])->name('form_login');
Route::get('/edit/user/{id}',[UserController::class,'edit'])->name('clients.user.edit');
Route::put('/update/user/{id}',[UserController::class,'update'])->name('clients.user.update');
Route::post('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/blog',[HomeController::class,'blog'])->name('blog');
Route::get('/login',[LoginController::class,'index'])->name('login');

//admin
Route::get('/admin/showlogin',[AdminController::class,'showLoginForm'])->name('show.login');
Route::get('/admin/show',[AdminController::class,'show']);
Route::post('admin/create',[AdminController::class,'create'])->name('create.admin');
Route::post('/loginAdmin',[AdminController::class,'loginPost'])->name('post.login');
Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');



Route::view('/users','users.showAll')->name('users.all');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
