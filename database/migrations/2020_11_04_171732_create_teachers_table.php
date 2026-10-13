<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();/*user table id */
            $table->foreign('user_id')->references('id')->on('users');/*users table id join */
            $table->string('stuffid');
            $table->string('name');
            $table->string('fname');
            $table->string('mname');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('religion');
            $table->string('maritalStatus');
            $table->string('phone')->nullable();
            $table->string('nid')->nullable();
            $table->string('education')->nullable();
            $table->string('subject')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('salary')->nullable();
            $table->string('contactType')->nullable();
            $table->string('shift')->nullable();
            $table->string('exprience')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->string('link3')->nullable();
            $table->string('link4')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->date('joiningdate');
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
        Schema::dropIfExists('teachers');
    }
}
