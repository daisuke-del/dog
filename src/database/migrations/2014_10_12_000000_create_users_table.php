<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('face_image')->nullable();
            $table->string('gender');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('age');
            $table->integer('salary');
            $table->integer('face_point')->default(0);
            $table->integer('height2');
            $table->integer('weight2');
            $table->integer('age2');
            $table->integer('salary2');
            $table->integer('face_point2')->default(0);
            $table->string('twitter_id')->nullable();
            $table->string('instagram_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->date('update_face_at')->default(Carbon::now());
            $table->date('create_date')->default(Carbon::now());
            $table->integer('face_image_void_flg')->default(0);
            $table->integer('yellow_card')->default(0);
            $table->integer('order_number')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
