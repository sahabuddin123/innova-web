<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batchs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stuff_id')->nullable();/*teachers table id */
            $table->foreign('stuff_id')->references('id')->on('teachers');/*teachers table id join */
            $table->string('batchnum');
            $table->string('totalseat');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->unsignedInteger('day1')->default(0)->nullable();
            $table->string('schedule1')->nullable();
            $table->unsignedInteger('day2')->default(0)->nullable();
            $table->string('schedule2')->nullable(); 
            $table->unsignedInteger('day3')->default(0)->nullable();
            $table->string('schedule3')->nullable();
            $table->unsignedInteger('day4')->default(0)->nullable();
            $table->string('schedule4')->nullable();
            $table->unsignedInteger('day5')->default(0)->nullable();
            $table->string('schedule5')->nullable();
            $table->unsignedInteger('day6')->default(0)->nullable();
            $table->string('schedule6')->nullable();
            $table->unsignedInteger('day7')->default(0)->nullable();
            $table->string('schedule7')->nullable();
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
        Schema::dropIfExists('batchs');
    }
}
