<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 会員登録・ログイン・更新
Route::prefix('user')->name('user.')->group(function () {
  Route::post('login', [UserController::class, 'login'])->name('login');
  Route::post('logout', [UserController::class, 'logout']);
  Route::post('signup', [UserController::class, 'signup']);
  Route::middleware('auth:sanctum')->group(function () {
    // マイページ
    Route::prefix('my')->name('my.')->group(function () {
      Route::get('/', [MypageController::class, 'index']);
    });
  });
});

Route::middleware('auth:sanctum')->group(function () {
  // 更新
  Route::post('foreget/password/email', [UserController::class, 'foregetPasswordEmail']);
  Route::post('foreget/password/auth', [UserController::class, 'foregetPasswordAuth']);
  Route::put('foreget/password/update', [UserController::class, 'foregetPasswordUpdate']);
});

