<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosisController;
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
Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
  Route::post('result', [DiagnosisController::class, 'result']);
  Route::post('choice', [DiagnosisController::class, 'choice']);
  Route::post('alert', [DiagnosisController::class, 'alert']);
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