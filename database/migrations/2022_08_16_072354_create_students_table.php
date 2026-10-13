<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();/*user table id */
            $table->foreign('user_id')->references('id')->on('users');/*users table id join */
            $table->unsignedBigInteger('course_id');/*course table id */
            $table->foreign('course_id')->references('id')->on('courses');/*courses table id join */
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('batch_id');/*batch table id */
            $table->foreign('batch_id')->references('id')->on('batchs');/*batch_id table id join */
            $table->string('sname');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('religion');
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('phone')->nullable();
            $table->string('nid')->nullable();
            $table->string('last_school')->nullable();
            $table->string('f_name');
            $table->string('f_phone')->nullable();
            $table->string('m_name');
            $table->string('m_phone')->nullable();
            $table->string('g_name');
            $table->string('g_phone');
            $table->string('rel_g');
            $table->string('discount')->nullable();
            $table->string('course_fee');
            $table->string('balance')->nullable();
            $table->string('ref')->nullable();
            $table->string('image')->nullable();
            $table->date('admission_date');
            $table->unsignedInteger('IsRegister')->default(1)->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
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
        Schema::dropIfExists('students');
    }
} 
