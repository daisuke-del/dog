<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_width')->nullable();
            $table->integer('max_width')->nullable();
            $table->integer('min_weight')->nullable();
            $table->integer('max_weight')->nullable();
            $table->integer('personality1');
            $table->integer('personality2');
            $table->integer('personality3');
            $table->integer('face');
            $table->string('country');
            $table->string('size');
            $table->string('group');
            $table->string('dog_image');
            $table->string('character')->nullable();
            $table->string('personal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breeds');
    }
}
