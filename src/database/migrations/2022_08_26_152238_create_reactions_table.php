<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->uuid('to_user_id');
            $table->foreign('to_user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->uuid('from_user_id');
            $table->foreign('from_user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->primary(['to_user_id','from_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reactions');
    }
}
