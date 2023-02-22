<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupportController;

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

// パートナー診断
Route::prefix('match')->name('match.')->group(function () {
  Route::post('result', [MatchController::class, 'result']);
  Route::post('choice', [MatchController::class, 'choice']);
  Route::post('alert', [MatchController::class, 'alert']);
});

// スライダー用画像を取得
Route::prefix('slider')->name('slider.')->group(function () {
  Route::post('match', [UserController::class, 'slider']);
  Route::post('signup', [UserController::class, 'signupSlider']);
});

// 確認系
Route::prefix('check')->name('check.')->group(function () {
  Route::post('email', [UserController::class, 'checkEmail']);
});

// ランキングを取得
Route::prefix('ranking')->name('ranking.')->group(function () {
  Route::get('get', [UserController::class, 'getRanking']);
});

// 問い合わせ
Route::prefix('support')->name('support.')->group(function () {
  Route::post('send', [SupportController::class, 'send']);
  Route::post('resolve', [SupportController::class, 'resolve']);
});