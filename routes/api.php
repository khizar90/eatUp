<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserVerifyController;
use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('userVerify' , [UserVerifyController::class, 'userVerify']);
Route::post('otpVerify' , [UserVerifyController::class, 'otpVerify']);
Route::post('register' , [RegisterController::class, 'register']);
Route::post('login' , [LoginController::class, 'login']);
Route::post('resetVerify' , [ResetPasswordController::class, 'resetVerify']);
Route::post('resetOtpVerify' , [ResetPasswordController::class, 'resetOtpVerify']);
Route::post('newPassword' , [ResetPasswordController::class, 'newPassword']);
Route::post('changePassword' , [ChangePasswordController::class, 'changePassword']);



Route::get('home' , [UserController::class, 'homePage']);
Route::post('foodDetail/{food_id}' , [UserController::class, 'foodDetail']);

Route::post('categoryfood/{cat_id}' , [UserController::class, 'categoryfood']);
Route::post('addRating' , [UserController::class, 'addRating']);


Route::get('categories' , [UserController::class, 'listCategories']);
Route::get('listRating/{food_id}' , [UserController::class, 'listRating']);
Route::get('listDeals' , [UserController::class, 'listDeals']);
Route::get('dealDetail/{deal_id}' , [UserController::class, 'dealDetail']);

Route::get('search' , [UserController::class, 'search']);
Route::post('favorite' , [UserController::class, 'favorite']);
Route::post('favoriteList' , [UserController::class, 'favoriteList']);

















