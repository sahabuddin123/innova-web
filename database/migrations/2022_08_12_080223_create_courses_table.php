<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('category_id')->references('id')->on('course_categories');/*users table id join */
            $table->unsignedBigInteger('category_id')->nullable();/*branches table id */
            $table->string('shortTitle');
            $table->string('name');
            $table->string('coursefee');
            $table->string('courseduration')->nullable();
            $table->string('lacture')->nullable();
            $table->string('totalmoduls')->nullable();
            $table->string('totalproject')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('overview')->nullable();
            $table->longtext('curriculum')->nullable();
            $table->longtext('software')->nullable();
            $table->longtext('trainee')->nullable();
            $table->longtext('jobPlacement')->nullable();
            $table->longtext('jobPosition')->nullable();
            $table->unsignedInteger('IsActive')->default(0)->nullable();
            $table->unsignedInteger('featured')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
