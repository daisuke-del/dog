<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Models\LoveDiagnosisPerson;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
  protected UserService $userService;

  public function __construct(UserService $userService)
  {
      $this->userService = $userService;
  }

  /**
   * マッチング結果を取得
   */
  public function result(Request $request)
  {
      $response = $this->userService->getResult($request);
      return json_encode($response, JSON_UNESCAPED_UNICODE);
  }

  /**
   * 好き or 嫌いボタン選択結果の更新
   */
  public function choice(Request $request)
  {
    $response = $this->userService->upDownDogPoint($request);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
  }

  /**
   * 不適切画像クリックによる警告処理
   */
  public function alert(Request $request)
  {
    $response = $this->userService->updateYellowAndGetFace($request);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
  }

  /**
   * 特定の人物を取得（slug指定）
   */
  public function person($id)
  {
    $person = LoveDiagnosisPerson::where('slug', $id)->first();

    if (!$person) {
      return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
      'name' => $person->name,
      'image' => $person->image_url,
      'comment' => $person->comment,
    ]);
  }

  public function storePerson(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'comment' => 'required|string',
      'image' => 'required|image|max:5120', // バリデーションもゆるめに
    ]);
    // 画像ファイルの取得
    $image = $request->file('image');

    // Intervention でリサイズ（幅500pxを基準、高さは比率維持）
    $resizedImage = Image::make($image)
      ->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize(); // 元より小さくしない
      })
      ->encode(); // バイナリ化

    // 保存先
    $filename = 'love_diagnosis_images/' . Str::random(10) . '.' . $image->getClientOriginalExtension();
    Storage::put('public/' . $filename, $resizedImage);

    $url = Storage::url('public/' . $filename);
    $slug = 'id-' . Str::random(6);

    $person = LoveDiagnosisPerson::create([
      'slug' => $slug,
      'name' => $request->name,
      'comment' => $request->comment,
      'image_url' => $url,
  ]);

    return response()->json(['slug' => $slug]);
  }
}
