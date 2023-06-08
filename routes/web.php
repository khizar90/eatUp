<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
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

Route::get('/', function () {
    return redirect()->route('loginPage');
});

Route::get('/insert', function () {
    $user = new Admin;

    $user->username = 'khizar';
    $user->password = Hash::make('qwerty');
    $user->save();

});









Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AdminLoginController::class, 'loginPage'])->name('loginPage');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('listCategories', [AdminController::class, 'listCategories'])->name('category');
    Route::post('addCategory', [AdminController::class, 'addCategory'])->name('addCategory');
    Route::get('deleteCategory/{cat_id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/logout',[AdminLoginController::class, 'logout'])->name('logout');
    Route::post('/{cat_id}/updateCatgory',[AdminController::class, 'updateCategory'])->name('updateCategory');

    Route::post('addSubCategory', [AdminController::class, 'addSubCategory'])->name('addSubCategories');
    Route::get('getCategories', [AdminController::class, 'getCategories'])->name('getCategories');
    Route::get('listSubCategories/{cat_id}', [AdminController::class, 'listSubCategories'])->name('listSubCategories');
    Route::get('deleteSubCategory/{cat_id}', [AdminController::class, 'deleteSubCategory'])->name('deleteSubCategory');
    Route::get('editSubCategory/{cat_id}', [AdminController::class, 'editSubCategory'])->name('editSubCategory');
    Route::post('updateSubCategory', [AdminController::class, 'updateSubCategory'])->name('updateSubCategory');

    Route::get('showadddeals', [AdminController::class, 'showadddeals'])->name('showadddeals');
    Route::post('adddeals', [AdminController::class, 'adddeals'])->name('adddeals');
    Route::post('updateDeals/{cat_id}', [AdminController::class, 'updateDeals'])->name('updateDeals');
    Route::get('listDeals', [AdminController::class, 'listDeals'])->name('listDeals');
    Route::get('deleteDeal/{cat_id}', [AdminController::class, 'deleteDeal'])->name('deleteDeal');
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
