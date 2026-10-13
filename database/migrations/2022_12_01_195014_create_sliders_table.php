<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subTitle')->nullable();
            $table->string('title')->nullable();
            $table->text('details')->nullable();
            $table->string('btnTxt')->nullable();
            $table->string('btnLink')->nullable();
            $table->string('btnTxtTwo')->nullable();
            $table->string('btnLinkwo')->nullable();
            $table->string('enrolStdTxt')->nullable();
            $table->string('sucesStdId')->nullable();
            $table->string('offerTxt')->nullable();
            $table->string('oferTxtContent')->nullable();
            $table->string('suprtText')->nullable();
            $table->string('suprtTextContent')->nullable();
            $table->string('IsActive')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
