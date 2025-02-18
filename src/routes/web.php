<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\DiagnosisController;

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
  Route::post('leave', [UserController::class, 'leave']);
  Route::middleware('auth:sanctum')->group(function () {
    // マイページ
    Route::prefix('my')->name('my.')->group(function () {
      Route::get('/', [MypageController::class, 'index']);
    });
    Route::get('dog/friend/{offset}', [UserController::class, 'getUsers']);
  });
  // パートナー診断結果取得
  Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
    Route::post('result', [DiagnosisController::class, 'result']);
  });
});

Route::middleware('auth:sanctum')->group(function () {
  // 更新
  Route::put('foreget/password/update', [UserController::class, 'foregetPasswordUpdate']);
  Route::post('update/email', [UserController::class, 'updateEmail']);
  Route::post('update/name', [UserController::class, 'updateName']);
  Route::post('update/weight', [UserController::class, 'updateWeight']);
  Route::post('update/breed', [UserController::class, 'updateBreed']);
  Route::post('update/birthday', [UserController::class, 'updateBirthday']);
  Route::post('update/location', [UserController::class, 'updateLocation']);
  Route::post('update/image', [UserController::class, 'updateDogImage']);
  Route::post('update/instagram', [UserController::class, 'updateInstagram']);
  Route::post('update/twitter', [UserController::class, 'updatetwitter']);
  Route::post('update/tiktok', [UserController::class, 'updateTiktok']);
  Route::post('update/blog', [UserController::class, 'updateBlog']);
  Route::post('update/comment', [UserController::class, 'updateComment']);
});

// お気に入り
Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('favorite')->name('favorite.')->group(function () {
    Route::post('add', [MypageController::class, 'addFavorite']);
    Route::delete('delete', [MypageController::class, 'deleteFavorite']);
    Route::prefix('mypage')->name('mypage.')->group(function () {
      Route::post('add', [MypageController::class, 'addFavoriteFromMypage']);
      Route::delete('delete', [MypageController::class, 'deleteFavoriteFromMypage']);
    });
  });
});

// 管理者
  Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('login', [UserController::class, 'adminLogin']);
    Route::middleware('auth:sanctum')->group(function () {
      Route::post('logout', [UserController::class, 'adminLogout']);
      Route::post('delete', [UserController::class, 'deleteVoidImage']);
      Route::get('info', [UserController::class, 'getInfo']);
      Route::post('update', [UserController::class, 'updateYellowCard']);
    });
  });

// お気に入り
Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('favorite')->name('favorite.')->group(function () {
    Route::post('add', [MypageController::class, 'addFavorite']);
    Route::delete('delete', [MypageController::class, 'deleteFavorite']);
    Route::get('ranking', [UserController::class, 'getRankingWithFriends']);
    Route::get('random', [UserController::class, 'randomWithFriends']);
  });
});

