<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeminorRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminor_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('seminor_id')->references('id')->on('seminors');/*seminors table id join */
            $table->unsignedBigInteger('seminor_id')->nullable();/*seminors table id */
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('isCall')->default(0)->nullable();
            $table->unsignedInteger('isAttand')->default(0)->nullable();
            $table->unsignedInteger('isConvance')->default(0)->nullable();
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
        Schema::dropIfExists('seminor_registrations');
    }
}
