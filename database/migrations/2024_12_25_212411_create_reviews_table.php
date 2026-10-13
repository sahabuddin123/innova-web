<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id')->nullable();/*user table id */
            $table->foreign('student_id')->references('id')->on('students');/*users table id join */
            $table->string('stdName')->nullable();
            $table->string('course')->nullable();
            $table->string('rating')->nullable();
            $table->text('msg')->nullable();
            $table->string('video')->nullable();
            $table->unsignedInteger('IsActive')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
