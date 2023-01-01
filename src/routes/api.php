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

Route::middleware(['auth:sanctum'])->group(function () {
  // マイページ
  Route::prefix('my')->name('my.')->group(function () {
    Route::get('/', [MypageController::class, 'index']);
  });
});

Route::middleware(['auth:sanctum'])->group(function () {
  Route::put('update/name', [UserController::class, 'updateHandleName']);
  Route::put('update/password', [UserController::class, 'updatePassword']);
  Route::put('update/email', [UserController::class, 'updateeEmail']);
  Route::put('update/email/auth', [UserController::class, 'updateEmailAuth']);
});

// マッチング診断
Route::prefix('match')->name('match.')->group(function () {
  Route::post('result', [MatchController::class, 'result']);
  Route::post('choice', [MatchController::class, 'choice']);
  Route::post('alert', [MatchController::class, 'alert']);
});

// スライダー用画像を取得
Route::prefix('slider')->name('slider.')->group(function () {
  Route::get('/', [UserController::class, 'slider']);
  Route::post('signup', [UserController::class, 'signupSlider']);
});