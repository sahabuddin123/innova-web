<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shortTitle')->nullable();
            $table->string('LongTitle')->nullable();
            $table->text('shortdetail')->nullable();
            $table->string('info1')->nullable();
            $table->string('info2')->nullable();
            $table->string('info3')->nullable();
            $table->string('btnTxt')->nullable();
            $table->string('btnLink')->nullable();
            $table->string('Reviews')->nullable();
            $table->string('Rating')->nullable();
            $table->string('stdId')->nullable();
            $table->string('bgimg1')->nullable();
            $table->string('bgimg2')->nullable();
            $table->string('video')->nullable();
            $table->string('successTraing')->nullable();
            $table->string('completeCourse')->nullable();
            $table->string('satisfaction')->nullable();
            $table->string('stdComunity')->nullable();
            $table->unsignedInteger('IsActive')->default(0)->nullable();
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
        Schema::dropIfExists('cms_abouts');
    }
}
