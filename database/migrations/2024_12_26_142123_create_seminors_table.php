<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeminorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('course_id')->references('id')->on('courses');/*courses table id join */
            $table->unsignedBigInteger('course_id')->nullable();/*courses table id */
            $table->string('title')->nullable();
            $table->text('address')->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('seminors');
    }
}
