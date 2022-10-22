<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum', 'checkActiveMember'])->group(function () {
  // マイページ
  Route::prefix('my')->name('my.')->group(function () {
    Route::get('/', [MypageController::class, 'index']);
  });
});

// 会員登録・ログイン・更新
Route::prefix('user')->name('user.')->group(function () {
  Route::post('signup', [UserController::class, 'signup']);
  Route::post('auth', [UserController::class, 'auth']);
  Route::post('foreget/password/email', [UserController::class, 'foregetPasswordEmail']);
  Route::post('foreget/password/auth', [UserController::class, 'foregetPasswordAuth']);
  Route::put('foreget/password/update', [UserController::class, 'foregetPasswordUpdate']);
  Route::post('login', [UserController::class, 'login']);
  Route::post('logout', [UserController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'checkActiveMember'])->group(function () {
  Route::put('update/name', [UserController::class, 'updateHandleName']);
  Route::put('update/password', [UserController::class, 'updatePassword']);
  Route::put('update/email', [UserController::class, 'updateeEmail']);
  Route::put('update/email/auth', [UserController::class, 'updateEmailAuth']);
});

// マッチング診断
Route::prefix('match')->name('match.')->group(function () {
  Route::post('result', [MatchController::class, 'result']);
  Route::get('slider', [MatchController::class, 'slider']);
  Route::post('choice', [MatchController::class, 'choice']);
});

