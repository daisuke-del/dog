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
            $table->string('dog_image1')->nullable();
            $table->string('dog_image2')->nullable();
            $table->string('dog_image3')->nullable();
            $table->string('sex')->nullable();
            $table->integer('weight');
            $table->dateTime('birthday')->format('Y-m-d')->nullable();
            $table->integer('dog_point')->default(0);
            $table->string('breed');
            $table->string('location')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('instagram_id')->nullable();
            $table->string('tiktok_id')->nullable();
            $table->string('blog_id')->nullable();
            $table->text('comment')->nullable();
            $table->dateTime('update_dog_at')->default(Carbon::now()->format('Y-m-d H:i:s'));
            $table->dateTime('create_date')->default(Carbon::now()->format('Y-m-d H:i:s'));
            $table->integer('dog_image_void_flg')->default(0);
            $table->integer('yellow_card')->default(0);
            $table->string('remember_token')->nullable();
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
