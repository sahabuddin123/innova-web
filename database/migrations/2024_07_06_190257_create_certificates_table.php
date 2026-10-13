<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id')->nullable();/*user table id */
            $table->foreign('student_id')->references('id')->on('students');/*users table id join */
            $table->unsignedBigInteger('session_id');/*course table id */
            $table->foreign('session_id')->references('id')->on('sessions');/*courses table id join */
            $table->string('regNo')->nullable();
            $table->string('cno')->nullable();
            $table->date('pDate')->nullable();
            $table->string('recevier')->nullable();
            $table->string('cimage')->nullable();
            $table->string('dimage')->nullable(); /*Deliverd Image */
            $table->string('Result')->nullable();
            $table->date('dDate')->nullable(); /*Deliverd Image */
            $table->string('IsActive')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
