<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

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

Route::post('/match/gender', [MatchController::class, 'gender']);

Route::post('/match/age', [MatchController::class, 'age']);

Route::post('/match/height', [MatchController::class, 'height']);

Route::post('/match/weight', [MatchController::class, 'weight']);

Route::post('/match/salary', [MatchController::class, 'salary']);

Route::post('/match/facePoint', [MatchController::class, 'facePoint']);

Route::get('/match/slider', [MatchController::class, 'sliderFace']);

