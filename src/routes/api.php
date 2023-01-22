<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
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

// マッチング診断
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
