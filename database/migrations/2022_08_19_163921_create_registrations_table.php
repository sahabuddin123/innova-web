<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id')->nullable();/*user table id */
            $table->foreign('student_id')->references('id')->on('students');/*users table id join */
            $table->unsignedBigInteger('session_id');/*course table id */
            $table->foreign('session_id')->references('id')->on('sessions');/*courses table id join */
            $table->string('ExamName')->nullable();
            $table->string('ExamBoard')->nullable();
            $table->string('ExamSession')->nullable();
            $table->string('ExamRoll')->nullable();
            $table->string('ExamReg')->nullable();
            $table->date('PassYear')->nullable();
            $table->string('Result')->nullable();
            $table->string('balance')->nullable();
            $table->string('IsActive')->nullable();
            $table->date('regDate')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
