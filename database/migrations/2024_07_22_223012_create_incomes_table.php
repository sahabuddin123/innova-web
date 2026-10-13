<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();/*user table id */
            $table->foreign('user_id')->references('id')->on('users');/*users table id join */
            $table->unsignedBigInteger('branch_id')->nullable();/*branches table id */
            $table->foreign('branch_id')->references('id')->on('branches');/*branches table id join */
            $table->unsignedBigInteger('categoris_id')->nullable();/*income_categoris table id */
            $table->foreign('categoris_id')->references('id')->on('income_categoris');/*income_categoris table id join */
            $table->string('bookNO')->nullable();
            $table->string('invoiceID')->nullable();
            $table->date('invoiceDate');
            $table->string('title')->nullable();
            $table->string('seller')->nullable();
            $table->string('recever')->nullable();
            $table->text('description')->nullable();
            $table->string('amount');
            $table->date('createDate');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
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
        Schema::dropIfExists('incomes');
    }
}
