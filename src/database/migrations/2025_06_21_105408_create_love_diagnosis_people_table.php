<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoveDiagnosisPeopleTable extends Migration
{
  public function up()
  {
    Schema::create('love_diagnosis_people', function (Blueprint $table) {
      $table->id();
      $table->string('slug')->unique(); // URL識別子（例: id-a）
      $table->string('name');           // 人物名
      $table->string('image_url');      // 表示する画像のパス
      $table->text('comment');          // マッチング時に表示するコメント
      $table->timestamps();
    });
  }

  public function down()
  {
      Schema::dropIfExists('love_diagnosis_people');
  }
}

